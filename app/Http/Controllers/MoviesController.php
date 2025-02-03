<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Movies;
use Validator;

class MoviesController extends Controller
{
    public function index()
    {
        $data = Movies::all();
        $response = [
            'success' => true,
            'data' => $data
        ];
        return $response;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'genre' => 'required',
            'durasi' => 'required',
            'rating' => 'required',
            'usia' => 'required',
            'poster' => 'mimetype:image/jpeg,png,jpg,gif,svg|max:1000|required',
        ]);

        $movies = new Movies();
        $movies->judul = $request->judul;
        $movies->genre = $request->genre;
        $movies->durasi = $request->durasi;
        $movies->rating = $request->rating;
        $movies->usia = $request->usia;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $filename = time() . '-' . uniqid() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $movies->poster = $filename;
        }
        $status = $movies->save();

        if ($status) {
            $response = [
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ];
            return $response;
        }else{
            $response = [
                'success' => false,
                'message' => 'Data gagal disimpan',
            ];
            return $response;
        }
    }

    public function show(string $id)
    {
        $movies = Movies::find($id);
        $response = [
            'success' => true,
            'data' => $movies
        ];
        return $response;
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'genre' => 'required',
            'durasi' => 'required',
            'rating' => 'required',
            'usia' => 'required',
            'poster' => 'mimetype:image/jpeg,png,jpg,gif,svg|max:1000|required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $movies = Movies::where('judul', $id)->first();
        $movies->judul = $request->judul;
        $movies->genre = $request->genre;
        $movies->durasi = $request->durasi;
        $movies->rating = $request->rating;
        $movies->usia = $request->usia;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $path = public_path('image/' . $movies->poster);
            if (File::exists($path)) { 
                File::delete($path);
            }
            $filename = $file->getClientOriginalExtension();
            $file->move(public_path('image'), $filename);
            $movies->poster = $filename;
        }
        $status = $movies->save();

        if ($status) {
            $response = [
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ];
            return $response;
        }else{
            $response = [
                'success' => false,
                'message' => 'Data gagal disimpan',
            ];
            return $response;
        }
    }

    public function destroy(string $id)
    {
        $movies = Movies::where('judul', $id)->first();
        $status = $movies->delete();
        if (!$status){
            $response = [
                'status' => false,
                'message' => 'Data gagal dihapus'
            ];
            return $response;
        }else{
            $response = [
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ];
            return $response;
        }
    }

    public function showImage (string $filename)
    {
        $path = public_path('images/' . $filename);
        if (!File::exists($path)) {
            return response()->json(['message' => 'Image not found'], 404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = response($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    }
}
