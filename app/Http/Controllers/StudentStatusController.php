<?php

namespace App\Http\Controllers;

use App\StudentStatus;
use Illuminate\Http\Request;

class StudentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ta'             => 'required',
            'status'            => 'required',
            'ipk_terakhir'      => 'nullable',
        ]);

        $nim = decrypt($request->_nim);

        $data                = new StudentStatus;
        $data->id_ta         = $request->id_ta;
        $data->nim           = decrypt($request->_nim);
        $data->status        = $request->status;
        $data->ipk_terakhir  = $request->ipk_terakhir;
        $q = $data->save();

        if(!$q) {
            return response()->json([
                'title'   => 'Gagal',
                'message' => 'Terjadi kesalahan',
                'type'    => 'error'
            ]);
        } else {
            return response()->json([
                'title'   => 'Berhasil',
                'message' => 'Data berhasil disimpan',
                'type'    => 'success'
            ]);
        }
    }

    public function edit($id)
    {
        if(request()->ajax()) {
            $id = decrypt($id);
            $data = StudentStatus::find($id);
            return response()->json($data);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentStatus  $studentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_ta'             => 'required',
            'ipk_terakhir'      => 'nullable',
        ]);

        $id = decrypt($request->_id);
        $nim = decrypt($request->_nim);

        $data                = StudentStatus::find($id);
        $data->id_ta         = $request->id_ta;
        $data->nim           = decrypt($request->_nim);
        $data->ipk_terakhir  = $request->ipk_terakhir;
        $q = $data->save();

        if(!$q) {
            return response()->json([
                'title'   => 'Gagal',
                'message' => 'Terjadi kesalahan',
                'type'    => 'error'
            ]);
        } else {
            return response()->json([
                'title'   => 'Berhasil',
                'message' => 'Data berhasil disunting',
                'type'    => 'success'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentStatus  $studentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->ajax()) {
            $id = decrypt($request->id);
            $q  = StudentStatus::find($id)->delete();
            if(!$q) {
                return response()->json([
                    'title'   => 'Gagal',
                    'message' => 'Terjadi kesalahan saat menghapus',
                    'type'    => 'error'
                ]);
            } else {
                return response()->json([
                    'title'   => 'Berhasil',
                    'message' => 'Data berhasil dihapus',
                    'type'    => 'success'
                ]);
            }
        }
    }
}
