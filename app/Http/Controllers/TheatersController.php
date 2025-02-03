<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theaters;
use Validator;

class TheatersController extends Controller
{
    /**
     * Display a listing of the theaters.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = Theaters::all();
        $response = [
            'success' => true,
            'data' => $data
        ];
        return response()->json($response);
    }

    /**
     * Store a newly created theater in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Data gagal disimpan',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified theater.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $theaters = Theaters::find($id);

        if (!$theaters) {
            return response()->json([
                'success' => false,
                'message' => 'Theater not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $theaters,
        ]);
    }

    /**
     * Update the specified theater in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $theaters = Theaters::find($id);

        if (!$theaters) {
            return response()->json([
                'success' => false,
                'message' => 'Theater not found',
            ], 404);
        }

        $theaters->nama = $request->nama;
        $status = $theaters->save();

        if ($status) {
            $response = [
                'success' => true,
                'message' => 'Data berhasil diupdate',
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Data gagal diupdate',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified theater from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $theaters = Theaters::find($id);

        if (!$theaters) {
            return response()->json([
                'success' => false,
                'message' => 'Theater not found',
            ], 404);
        }

        $status = $theaters->delete();

        if ($status) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus',
            ], 500);
        }
    }
}