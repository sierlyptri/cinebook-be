<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theaters;
use Validator;

class TheatersController extends Controller
{
    public function index()
    {
        $data = Theaters::all();
        $response = [
            'success' => true,
            'data' => $data
        ];
        return $response;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $theaters = new Theaters();
        $theaters->nama = $request->nama;
        $status = $theaters->save();

        if ($status) {
            $response = [
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ];
            return $response;
        } else {
            $response = [
                'success' => false,
                'message' => 'Data gagal disimpan',
            ];
            return $response;
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $theaters = Theaters::find($id);
        $theaters->nama = $request->nama;
        $status = $theaters->save();

        if ($status) {
            $response = [
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ];
            return $response;
        } else {
            $response = [
                'success' => false,
                'message' => 'Data gagal disimpan',
            ];
            return $response;
        }
    }
    
    public function destroy($id)
    {
        $theaters = Theaters::find($id);
        $status = $theaters->delete();
        if ($status) {
            $response = [
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ];
            return $response;
        } else {
            $response = [
                'success' => false,
                'message' => 'Data gagal dihapus',
            ];
            return $response;
        }
    }

    public function show($id)
    {
        $theaters = Theaters::find($id);
        $response = [
            'success' => true,
            'data' => $theaters
        ];
        return $response;
    }
}
