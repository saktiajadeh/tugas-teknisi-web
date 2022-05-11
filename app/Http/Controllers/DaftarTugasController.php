<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\TugasTeknisi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DaftarTugasController extends Controller
{
    public function __construct(){
        $this->middleware('role:teknisi');
    }
    public function daftarTugasSelesai()
    {
        return view('daftartugas.selesai');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('daftartugas.index');
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
        //
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

        $input['foto'] = $data->foto;

        if ($request->hasFile('foto')){
            if (!$data->foto == NULL){
                unlink(public_path($data->foto));
            }
            $input['foto'] = '/upload/tugasteknisi/' . $input['id'] . '-' . str_replace(' ', '-', $data->kategorijasa->nama) . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('/upload/tugasteknisi/'), $input['foto']);
        }

        $data->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Status Tugas Berhasil Diubah'
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
        //
    }

    public function apiDaftarTugas()
    {
        $idTeknisi = Auth::user()->id;
        $data = TugasTeknisi::where('karyawan_id', '=', $idTeknisi)->where('status', '!=', 'finish')->orderBy('status')->get();

        return Datatables::of($data)
            ->addColumn('nama_pelanggan', function ($data){
                return $data->pelanggan->nama;
            })
            ->addColumn('alamat_pelanggan', function ($data){
                return $data->pelanggan->alamat;
            })
            ->addColumn('no_telp_pelanggan', function ($data){
                return $data->pelanggan->no_telp;
            })
            ->addColumn('nama_kategori_jasa', function ($data){
                return $data->kategorijasa->nama;
            })
            ->addColumn('nama_karyawan', function ($data){
                return $data->karyawan->name;
            })
            ->addColumn('mulai_info', function ($data){
                return 'Jam: ' . $data->jam_mulai . ', Tanggal: '. $data->tanggal_mulai;
            })
            ->addColumn('selesai_info', function ($data){
                return 'Jam: ' . $data->jam_selesai . ', Tanggal: '. $data->tanggal_selesai;
            })
            ->addColumn('show_photo', function($data){
                if ($data->foto == NULL){
                    return 'Foto belum ada';
                }
                return '<img class="rounded-square" width="60" height="60" src="'. url($data->foto) .'" alt="" style="object-fit: contain;">';
            })
            ->addColumn('status_info', function ($data){
                $info = null;
                if($data->status === "nostatus"){
                    return '<span class="badge bg-secondary">Belum Dikerjakan</span>';
                }
                if($data->status === "progress"){
                    return '<span class="badge bg-primary">Sedang Dikerjakan</span>';
                }
                if($data->status === "finish"){
                    return '<span class="badge bg-success">Selesai</span>';
                }
            })
            ->addColumn('action', function ($data){
                $info = null;
                if($data->status === "nostatus"){
                    return '<a onclick="mulaiKerjakanForm('. $data->id .')" class="btn btn-outline-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-flag"></i> Mulai?</a> ';
                }
                if($data->status === "progress"){
                    return '<a onclick="selesaiForm('. $data->id .')" class="btn btn-outline-success btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-android-checkmark-circle"></i> Selesai?</a> ';
                }
            })
            ->rawColumns(['show_photo', 'status_info', 'action'])->make(true);
    }

    public function apiDaftarTugasSelesai()
    {
        $idTeknisi = Auth::user()->id;
        $data = TugasTeknisi::where('karyawan_id', '=', $idTeknisi)->where('status', '=', 'finish')->get();

        return Datatables::of($data)
            ->addColumn('nama_pelanggan', function ($data){
                return $data->pelanggan->nama;
            })
            ->addColumn('alamat_pelanggan', function ($data){
                return $data->pelanggan->alamat;
            })
            ->addColumn('no_telp_pelanggan', function ($data){
                return $data->pelanggan->no_telp;
            })
            ->addColumn('nama_kategori_jasa', function ($data){
                return $data->kategorijasa->nama;
            })
            ->addColumn('nama_karyawan', function ($data){
                return $data->karyawan->name;
            })
            ->addColumn('mulai_info', function ($data){
                return 'Jam: ' . $data->jam_mulai . ', Tanggal: '. $data->tanggal_mulai;
            })
            ->addColumn('selesai_info', function ($data){
                return 'Jam: ' . $data->jam_selesai . ', Tanggal: '. $data->tanggal_selesai;
            })
            ->addColumn('show_photo', function($data){
                if ($data->foto == NULL){
                    return 'Foto belum ada';
                }
                return '<img class="rounded-square" width="60" height="60" src="'. url($data->foto) .'" alt="" style="object-fit: contain;">';
            })
            ->addColumn('status_info', function ($data){
                $info = null;
                if($data->status === "nostatus"){
                    return '<span class="badge bg-secondary">Belum Dikerjakan</span>';
                }
                if($data->status === "progress"){
                    return '<span class="badge bg-primary">Sedang Dikerjakan</span>';
                }
                if($data->status === "finish"){
                    return '<span class="badge bg-success">Selesai</span>';
                }
            })
            ->rawColumns(['show_photo', 'status_info'])->make(true);
    }
}
