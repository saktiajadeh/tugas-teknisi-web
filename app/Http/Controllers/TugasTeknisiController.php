<?php

namespace App\Http\Controllers;

use App\Models\TugasTeknisi;
use App\Models\KategoriJasa;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;

class TugasTeknisiController extends Controller
{
    public function __construct(){
        $this->middleware('role:admin');
    }
    public function laporanTugasTeknisi()
    {
        $pelanggan = Pelanggan::select('id','nama', 'alamat')->orderBy('nama')->get();
        $kategorijasa = KategoriJasa::select('nama','id')->get();
        $teknisi = User::select('name','id')->where('role', '=', 'teknisi')->orderBy('name')->get();
        return view('tugasteknisi.laporan', compact('pelanggan', 'kategorijasa', 'teknisi'));
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

        return view('tugasteknisi.index', compact('pelanggan', 'kategorijasa', 'teknisi'));
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
            'karyawan_id'       => 'required',
        ]);

        TugasTeknisi::create($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Tugas Teknisi Berhasil Ditambah'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TugasTeknisi  $tugasTeknisi
     * @return \Illuminate\Http\Response
     */
    public function show(TugasTeknisi $tugasTeknisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TugasTeknisi  $tugasTeknisi
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
     * @param  \App\Models\TugasTeknisi  $tugasTeknisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'karyawan_id'       => 'required',
        ]);

        $data = TugasTeknisi::findOrFail($id);

        $data->update($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Tugas Teknisi Berhasil Diserahkan'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TugasTeknisi  $tugasTeknisi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TugasTeknisi::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Tugas Teknisi Berhasil Dihapus'
        ]);
    }

    public function apiTugasTeknisi()
    {
        $data = TugasTeknisi::all();

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
                return 'Tanggal: ' . $data->tanggal_mulai . ', ' . $data->jam_mulai;
            })
            ->addColumn('selesai_info', function ($data){
                if($data->tanggal_selesai != null && $data->jam_selesai != null){
                    return 'Tanggal: ' . $data->tanggal_selesai . ', ' . $data->jam_selesai;
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
            ->addColumn('action', function($data){
                if($data->karyawan_id === 0){
                    return '<a onclick="editForm('. $data->id .')" class="btn btn-outline-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-edit"></i> Serahkan Tugas</a> ';
                }
                return '<span class="badge bg-primary">Tugas sudah Diserahkan kepada '. $data->karyawan->name .'</span>';
            })
            ->rawColumns(['show_foto_mulai', 'show_foto_selesai', 'status_info', 'action'])->make(true);
    }

    public function apiLaporanTugasTeknisi(Request $request)
    {
        $filter_pelanggan = (int)$request->filter_pelanggan ?? null;
        $filter_kategorijasa = (int)$request->filter_kategorijasa ?? null;
        $filter_teknisi = (int)$request->filter_teknisi ?? null;

        $data = TugasTeknisi::where('status', '=', 'finish');

        if($filter_pelanggan != null){
            $data->where('pelanggan_id', '=', $filter_pelanggan);
        }
        if($filter_kategorijasa != null){
            $data->where('kategori_jasa_id', '=', $filter_kategorijasa);
        }
        if($filter_teknisi != null){
            $data->where('karyawan_id', '=', $filter_teknisi);
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
                return 'Tanggal: ' . $data->tanggal_mulai . ', ' . $data->jam_mulai;
            })
            ->addColumn('nama_karyawan', function ($data){
                return $data->karyawan->name;
            })
            ->addColumn('selesai_info', function ($data){
                if($data->tanggal_selesai != null && $data->jam_selesai != null){
                    return 'Tanggal: ' . $data->tanggal_selesai . ', ' . $data->jam_selesai;
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
            ->rawColumns(['show_foto_mulai', 'show_foto_selesai', 'status_info'])->make(true);
    }

    public function exportLaporanTugasTeknisi()
    {
        $laporan = TugasTeknisi::where('status', '=', 'finish')->get();
        $tanggal_mulai = TugasTeknisi::where('status', '=', 'finish')->orderBy('tanggal_mulai', 'ASC')->limit(1)->first();
        $tanggal_selesai = TugasTeknisi::where('status', '=', 'finish')->orderBy('tanggal_selesai', 'DESC')->limit(1)->first();
        
        $pdf = PDF::loadView('tugasteknisi.cetakLaporanPDF',compact('laporan', 'tanggal_mulai', 'tanggal_selesai'));
        return $pdf->setPaper('a4', 'landscape')->download('Laporan Tugas Teknisi.pdf');
    }
}
