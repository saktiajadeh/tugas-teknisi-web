<?php

namespace App\Http\Controllers;

use App\Models\TugasTeknisi;
use App\Models\KategoriJasa;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServisOrderController extends Controller
{
    public function __construct(){
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelanggan = Pelanggan::orderBy('nama')->get()->pluck('nama','id');
        $kategorijasa = KategoriJasa::get()->pluck('nama','id');
        $teknisi = User::where('role', '=', 'teknisi')->orderBy('name')->get()->pluck('name','id');
        $tugasteknisi = TugasTeknisi::all();

        return view('servisorder.index', compact('pelanggan', 'kategorijasa', 'teknisi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pelanggan_id'      => 'required',
            'kategori_jasa_id'  => 'required',
            'detail'            => 'required|string|min:2',
            'foto_dokumen'      => 'required',
            'jadwal_mulai'      => 'required',
        ]);
        
        $newData = [
            'pelanggan_id'      => $request['pelanggan_id'],
            'kategori_jasa_id'  => $request['kategori_jasa_id'],
            'karyawan_id'       => 0,
            'detail'            => $request['detail'],
            'jam_mulai'         => date("H:i:s", strtotime($request->jadwal_mulai)),
            'tanggal_mulai'     => date("Y-m-d", strtotime($request->jadwal_mulai)),
        ];

        $createdData = TugasTeknisi::create($newData);

        if ($request->hasFile('foto_dokumen')){
            if (!$createdData->foto_dokumen == NULL){
                unlink(public_path($createdData->foto_dokumen));
            }
            $data = TugasTeknisi::findOrFail($createdData->id);

            $data['foto_dokumen'] = '/upload/tugasteknisi/' . $createdData['id'] . '-foto-dokumen' . '.' . $request->foto_dokumen->getClientOriginalExtension();
            $request->foto_dokumen->move(public_path('/upload/tugasteknisi/'), $data['foto_dokumen']);

            $data->update();
        }

        return response()->json([
            'success'    => true,
            'message'    => 'Servis Order Berhasil Ditambah'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = TugasTeknisi::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $data = TugasTeknisi::findOrFail($id);

        $input['foto_dokumen'] = $data->foto_dokumen;
        $input['jam_mulai'] = date("H:i:s", strtotime($request->jadwal_mulai));
        $input['tanggal_mulai'] = date("Y-m-d", strtotime($request->jadwal_mulai));

        if ($request->hasFile('foto_dokumen')){
            if (!$data->foto_dokumen == NULL){
                unlink(public_path($data->foto_dokumen));
            }
            $input['foto_dokumen'] = '/upload/tugasteknisi/' . $input['id'] . '-foto-dokumen' . '.' . $request->foto_dokumen->getClientOriginalExtension();
            $request->foto_dokumen->move(public_path('/upload/tugasteknisi/'), $input['foto_dokumen']);
        }

        $data->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Servis Order Berhasil Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TugasTeknisi::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Servis Order Berhasil Dihapus'
        ]);
    }

    public function apiServisOrder()
    {
        $data = TugasTeknisi::all();

        return Datatables::of($data)
            ->addColumn('nama_pelanggan', function ($data){
                return $data->pelanggan->nama;
            })
            ->addColumn('alamat_pelanggan', function ($data){
                return $data->pelanggan->alamat;
            })
            ->addColumn('nama_kategori_jasa', function ($data){
                return $data->kategorijasa->nama;
            })
            ->addColumn('mulai_info', function ($data){
                return 'Tanggal: ' . $data->tanggal_mulai . ', ' . $data->jam_mulai;
            })
            ->addColumn('show_foto_dokumen', function($data){
                if ($data->foto_dokumen == NULL){
                    return 'Foto belum ada';
                }
                return '<img class="rounded-square" width="60" height="60" src="'. url($data->foto_dokumen) .'" alt="" style="object-fit: contain;">';
            })
            ->addColumn('action', function($data){
                return '<a onclick="editForm('. $data->id .')" class="btn btn-outline-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-edit"></i> Ubah</a> ' .
                    '<a onclick="deleteData('. $data->id .')" class="btn btn-outline-danger btn-sm mb-2" style="min-width: 65px;"><i class="ion-trash-a"></i> Hapus</a>';
            })
            ->rawColumns(['show_foto_dokumen', 'action'])->make(true);
    }
}
