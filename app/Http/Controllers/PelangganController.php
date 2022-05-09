<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PelangganController extends Controller
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
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan', $pelanggan));
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
            'nama'      => 'required',
            'no_telp'    => 'required',
            'alamat'   => 'required',
            'email'     => 'required',
        ]);

        Pelanggan::create($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Pelanggan Berhasil Ditambah'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pelanggan::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama'      => 'required|string|min:2',
            'no_telp'    => 'required|string|min:2',
            'alamat'   => 'required|string|min:2',
            'email'     => 'required|string|email|max:255',
        ]);

        $data = Pelanggan::findOrFail($id);

        $data->update($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Pelanggan Berhasil Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pelanggan::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Pelanggan Berhasil Dihapus'
        ]);
    }

    public function apiPelanggan()
    {
        $data = Pelanggan::all();

        return Datatables::of($data)
            ->addColumn('action', function($data){
                return '<a onclick="editForm('. $data->id .')" class="btn btn-outline-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-edit"></i> Ubah</a> ' .
                    '<a onclick="deleteData('. $data->id .')" class="btn btn-outline-danger btn-sm mb-2" style="min-width: 65px;"><i class="ion-trash-a"></i> Hapus</a>';
            })
            ->rawColumns(['action'])->make(true);
    }
}
