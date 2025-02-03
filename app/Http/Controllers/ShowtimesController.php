<?php

namespace App\Http\Controllers;

use App\Models\Showtimes;
use Illuminate\Http\Request;
use Validator;

class ShowtimesController extends Controller
{
    /**
     * Display a listing of the showtimes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = Showtimes::all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created showtime in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'movies_id' => 'required|exists:movies,id',
            'theaters_id' => 'required|exists:theaters,id',
            'jam_tayang' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $showtimes = new Showtimes();
        $showtimes->movies_id = $request->movies_id;
        $showtimes->theaters_id = $request->theaters_id;
        $showtimes->jam_tayang = $request->jam_tayang;
        $status = $showtimes->save();

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
     * Display the specified showtime.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $showtimes = Showtimes::find($id);
        $response = [
            'success' => true,
            'data' => $showtimes
        ];
        return response()->json($response);
    }

    /**
     * Update the specified showtime in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'movies_id' => 'required|exists:movies,id',
            'theaters_id' => 'required|exists:theaters,id',
            'jam_tayang' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $showtimes = Showtimes::find($id);
        if ($showtimes) {
            $showtimes->movies_id = $request->movies_id;
            $showtimes->theaters_id = $request->theaters_id;
            $showtimes->jam_tayang = $request->jam_tayang;
            $status = $showtimes->save();

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
        } else {
            $response = [
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ];
            return response()->json($response, 404);
        }
    }

    /**
     * Remove the specified showtime from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $showtimes = Showtimes::find($id);
        if ($showtimes) {
            $status = $showtimes->delete();
            if ($status) {
                $response = [
                    'success' => true,
                    'message' => 'Data berhasil dihapus',
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Data gagal dihapus',
                ];
                return response()->json($response, 500);
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ];
            return response()->json($response, 404);
        }
    }
}