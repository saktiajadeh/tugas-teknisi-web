<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\KategoriJasa;
use App\Models\TugasTeknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $karyawan = User::all()->count();
        $pelanggan = Pelanggan::all()->count();
        $kategorijasa = KategoriJasa::all()->count();
        $servisorder = TugasTeknisi::all()->count();
        $tugasteknisi = TugasTeknisi::where('karyawan_id', '!=', 0)->count();

        $idTeknisi = Auth::user()->id;
        $daftartugas = TugasTeknisi::where('karyawan_id', '=', $idTeknisi)->where('status', '!=', 'finish')->orderBy('status')->get()->count();
        $tugasselesai = TugasTeknisi::where('karyawan_id', '=', $idTeknisi)->where('status', '=', 'finish')->get()->count();

        $totalData = (Object)[
            'karyawan' => $karyawan ?? null,
            'pelanggan' => $pelanggan ?? null,
            'kategorijasa' => $kategorijasa ?? null,
            'servisorder' => $servisorder ?? null,
            'tugasteknisi' => $tugasteknisi ?? null,
            'daftartugas' => $daftartugas ?? null,
            'tugasselesai' => $tugasselesai ?? null,
        ];
        return view('home', compact('totalData'));
    }

    public function apiBarChart(Request $request)
    {
        $filter_tanggal = $request->filter_tanggal ?? null;
        $filterlast = false;
        if($filter_tanggal === "today"){
            $filter_tanggal = Carbon::now()->format('Y-m-d');
        }
        if($filter_tanggal === "last7days"){
            $filterlast = true;
            $filter_tanggal = Carbon::now()->subWeek()->format('Y-m-d');
        }
        if($filter_tanggal === "last30days"){
            $filterlast = true;
            $filter_tanggal = Carbon::now()->subMonth()->format('Y-m-d');
        }
        $data = User::where('role', '=', 'teknisi')->withCount(['tugasteknisiselesai' => function($q) use ($filter_tanggal, $filterlast){
            if($filter_tanggal != null){
                if($filterlast){
                    $q->where('tugas_teknisi.tanggal_selesai', '>=', $filter_tanggal);
                } else {    
                    $q->where('tugas_teknisi.tanggal_selesai', '=', $filter_tanggal);
                }
                
            }
          }])->get();

          return response()->json([
            'success'    => true,
            'message'    => 'Data Retrieved',
            'data'       => $data
        ]);
    }
}
