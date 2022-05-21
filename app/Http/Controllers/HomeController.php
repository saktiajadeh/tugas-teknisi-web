<?php

namespace App\Http\Controllers;

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
        $tugasteknisi = TugasTeknisi::all()->count();

        $idTeknisi = Auth::user()->id;
        $daftartugas = TugasTeknisi::where('karyawan_id', '=', $idTeknisi)->where('status', '!=', 'finish')->orderBy('status')->get()->count();
        $tugasselesai = TugasTeknisi::where('karyawan_id', '=', $idTeknisi)->where('status', '=', 'finish')->get()->count();

        $totalData = (Object)[
            'karyawan' => $karyawan ?? null,
            'pelanggan' => $pelanggan ?? null,
            'kategorijasa' => $kategorijasa ?? null,
            'tugasteknisi' => $tugasteknisi ?? null,
            'daftartugas' => $daftartugas ?? null,
            'tugasselesai' => $tugasselesai ?? null,
        ];
        return view('home', compact('totalData'));
    }
}
