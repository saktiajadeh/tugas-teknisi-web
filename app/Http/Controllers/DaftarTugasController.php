<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use App\Models\KategoriJasa;
use App\Models\TugasTeknisi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DaftarTugasController extends Controller
{
    public function __construct(){
        $this->middleware('role:teknisi');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idTeknisi = Auth::user()->id;
        $pelanggan = Pelanggan::orderBy('nama')
            ->whereHas('tugasteknisi', function($query) use($idTeknisi){
                $query->where('tugas_teknisi.karyawan_id', '=', $idTeknisi);
            })->get();
        $kategorijasa = KategoriJasa::select('nama','id')->get();
        return view('daftartugas.index', compact('pelanggan', 'kategorijasa'));
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
        $data = TugasTeknisi::where('id', '=', $id)->with(['karyawan'])->with(['pelanggan'])->with(['kategorijasa'])->first();
        $data["mulai_info"] = $data->tanggal_mulai . ', ' . $data->jam_mulai;
        $data["selesai_info"] = "-";
        if($data->tanggal_selesai != null && $data->jam_selesai != null){
            $data["selesai_info"] = $data->tanggal_selesai . ', ' . $data->jam_selesai;
        }
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
        $jam_selesai = $request['jam_selesai'] ?? null;
        $tanggal_selesai = $request['tanggal_selesai'] ?? null;
        $data = TugasTeknisi::findOrFail($id);

        if ($jam_selesai != null){
            $data->jam_selesai = $request->jam_selesai;
        }
        if ($tanggal_selesai != null){
            $data->tanggal_selesai = $request->tanggal_selesai;
        }

        $input['foto_mulai'] = $data->foto_mulai;
        if ($request->hasFile('foto_mulai')){
            if (!$data->foto_mulai == NULL){
                unlink(public_path($data->foto_mulai));
            }
            $input['foto_mulai'] = '/upload/tugasteknisi/' . $input['id'] . '-foto-mulai' . '.' . $request->foto_mulai->getClientOriginalExtension();
            $request->foto_mulai->move(public_path('/upload/tugasteknisi/'), $input['foto_mulai']);
        }

        $input['foto_selesai'] = $data->foto_selesai;
        if ($request->hasFile('foto_selesai')){
            if (!$data->foto_selesai == NULL){
                unlink(public_path($data->foto_selesai));
            }
            $input['foto_selesai'] = '/upload/tugasteknisi/' . $input['id'] . '-foto-selesai' . '.' . $request->foto_selesai->getClientOriginalExtension();
            $request->foto_selesai->move(public_path('/upload/tugasteknisi/'), $input['foto_selesai']);
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

    public function apiDaftarTugas(Request $request)
    {
        $filter_pelanggan = (int)$request->filter_pelanggan ?? null;
        $filter_kategorijasa = (int)$request->filter_kategorijasa ?? null;
        $filter_status = $request->filter_status ?? null;
        $tanggal_mulai = $request->tanggal_mulai . " 00:00:00" ?? null;
        $tanggal_selesai = $request->tanggal_selesai . " 23:59:59" ?? null;

        $idTeknisi = Auth::user()->id;
        $data = TugasTeknisi::where('karyawan_id', '=', $idTeknisi)->orderBy('updated_at', 'DESC');

        if($filter_pelanggan != null){
            $data->where('pelanggan_id', '=', $filter_pelanggan);
        }
        if($filter_kategorijasa != null){
            $data->where('kategori_jasa_id', '=', $filter_kategorijasa);
        }
        if($filter_status != null){
            $data->where('status', '=', $filter_status);
        }
        if($request->tanggal_mulai != null && $request->tanggal_selesai != null){
            $data->where('tanggal_mulai', '>=', $tanggal_mulai)
            ->where('tanggal_selesai', '<=', $tanggal_selesai);
        }
        
        $data = $data->get();

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
            ->addColumn('mulai_info', function ($data){
                return $data->tanggal_mulai . ', ' . $data->jam_mulai;
            })
            ->addColumn('selesai_info', function ($data){
                if($data->tanggal_selesai != null && $data->jam_selesai != null){
                    return $data->tanggal_selesai . ', ' . $data->jam_selesai;
                }
                return "-";
            })
            ->addColumn('show_foto_mulai', function($data){
                if ($data->foto_mulai == NULL){
                    return 'Foto belum ada';
                }
                return '<img class="rounded-square" width="60" height="60" src="'. url($data->foto_mulai) .'" alt="" style="object-fit: contain;">';
            })
            ->addColumn('show_foto_selesai', function($data){
                if ($data->foto_selesai == NULL){
                    return 'Foto belum ada';
                }
                return '<img class="rounded-square" width="60" height="60" src="'. url($data->foto_selesai) .'" alt="" style="object-fit: contain;">';
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
                    return '<a onclick="detail('. $data->id .')" class="btn btn-outline-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-folder me-1"></i> Detail</a>
                    <a onclick="mulaiKerjakanForm('. $data->id .')" class="btn btn-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-flag me-1"></i> Mulai?</a>';
                }
                if($data->status === "progress"){
                    return '
                    <a onclick="detail('. $data->id .')" class="btn btn-outline-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-folder me-1"></i> Detail</a>
                    <a onclick="selesaiForm('. $data->id .')" class="btn btn-success btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-android-checkmark-circle me-1"></i> Selesai?</a> ';
                }
                if($data->status === "finish"){
                    return '<a onclick="detail('. $data->id .')" class="btn btn-outline-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-folder me-1"></i> Detail</a>';
                }
            })
            ->rawColumns(['show_foto_mulai', 'show_foto_selesai', 'status_info', 'action'])->make(true);
    }

}
