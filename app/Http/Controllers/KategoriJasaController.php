<?php

namespace App\Http\Controllers;

use App\Models\KategoriJasa;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KategoriJasaController extends Controller
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
        $kategorijasa = KategoriJasa::all();
        return view('kategorijasa.index', compact('kategorijasa', $kategorijasa));
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
        ]);

        KategoriJasa::create($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Kategori Jasa Berhasil Ditambah'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KategoriJasa  $kategoriJasa
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriJasa $kategoriJasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriJasa  $kategoriJasa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = KategoriJasa::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KategoriJasa  $kategoriJasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama'      => 'required|string|min:2',
        ]);

        $data = KategoriJasa::findOrFail($id);

        $data->update($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Kategori Jasa Berhasil Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriJasa  $kategoriJasa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KategoriJasa::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Kategori Jasa Berhasil Dihapus'
        ]);
    }

    public function apiKategoriJasa()
    {
        $data = KategoriJasa::all();

        return Datatables::of($data)
            ->addColumn('action', function($data){
                return '<a onclick="editForm('. $data->id .')" class="btn btn-outline-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-edit"></i> Ubah</a> ' .
                    '<a onclick="deleteData('. $data->id .')" class="btn btn-outline-danger btn-sm mb-2" style="min-width: 65px;"><i class="ion-trash-a"></i> Hapus</a>';
            })
            ->rawColumns(['action'])->make(true);
    }
}
