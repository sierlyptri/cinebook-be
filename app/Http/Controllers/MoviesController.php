<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movies;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MoviesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        $movies = Movies::all();
        return response()->json([
            'success' => true,
            'data' => $movies,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'durasi' => 'required|string',
            'rating' => 'required|string',
            'usia' => 'required|string',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $movies = new Movies();
        $movies->judul = $request->judul;
        $movies->genre = $request->genre;
        $movies->durasi = $request->durasi;
        $movies->rating = $request->rating;
        $movies->usia = $request->usia;

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $movies->poster = $path;
        }

        if ($movies->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Movie created successfully',
                'data' => $movies,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Movie creation failed',
        ], 500);
    }

    public function show($id)
    {
        $movies = Movies::find($id);

        if (!$movies) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $movies,
        ]);
    }

    public function update(Request $request, $id)
    {
        $movies = Movies::find($id);

        if (!$movies) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'sometimes|required|string|max:255',
            'genre' => 'sometimes|required|string|max:255',
            'durasi' => 'sometimes|required|string',
            'rating' => 'sometimes|required|string',
            'usia' => 'sometimes|required|string',
            'poster' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $movies->fill($request->except('poster'));

        if ($request->hasFile('poster')) {
            if ($movies->poster) {
                Storage::disk('public')->delete($movies->poster);
            }

            $path = $request->file('poster')->store('posters', 'public');
            $movies->poster = $path;
        }

        if ($movies->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Movie updated successfully',
                'data' => $movies,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Movie update failed',
        ], 500);
    }

    public function destroy($id)
    {
        $movie = Movies::find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found',
            ], 404);
        }

        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }

        if ($movie->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Movie deleted successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Movie deletion failed',
        ], 500);
    }
}
