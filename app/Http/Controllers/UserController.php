<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $karyawan = User::all();
        return view('karyawan.index', compact('karyawan', $karyawan));
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
            'role'      => 'required',
            'name'      => 'required',
            'email'    => 'required',
            'no_telp'   => 'required',
            'alamat'     => 'required',
            'password'     => 'required',
        ]);

        User::create([
            'role'      => $request->role,
            'name'      => $request->name,
            'email'    => $request->email,
            'no_telp'   => $request->no_telp,
            'alamat'     => $request->alamat,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Karyawan Berhasil Ditambah'
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
        $data = User::find($id);
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
        $this->validate($request, [
            'role'      => 'required',
            'name'      => 'required|string|min:2',
            'email'     => 'required|string|email|max:255',
            'no_telp'    => 'required|string|min:2',
            'alamat'   => 'required|string|min:2',
        ]);

        $data = User::findOrFail($id);

        $data->update($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Karyawan Berhasil Diubah'
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
        User::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Karyawan Berhasil Dihapus'
        ]);
    }

    public function apiKaryawan()
    {
        $data = User::all();

        return Datatables::of($data)
            ->addColumn('role_info', function($data){
                return '<span class="badge bg-secondary">'. $data->role .'</span>';
            })
            ->addColumn('action', function($data){
                return '<a onclick="editForm('. $data->id .')" class="btn btn-outline-primary btn-sm me-2 mb-2" style="min-width: 65px;"><i class="ion-edit"></i> Ubah</a> ' .
                    '<a onclick="deleteData('. $data->id .')" class="btn btn-outline-danger btn-sm mb-2" style="min-width: 65px;"><i class="ion-trash-a"></i> Hapus</a>';
            })
            ->rawColumns(['role_info', 'action'])->make(true);
    }
}
