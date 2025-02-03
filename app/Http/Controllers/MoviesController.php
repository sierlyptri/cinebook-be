<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movies;
use Validator;

class MoviesController extends Controller
{
    /**
     * Display a listing of the movies.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $movies = Movies::all();
        return response()->json([
            'success' => true,
            'data' => $movies,
        ]);
    }

    /**
     * Store a newly created movie in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'durasi' => 'required|integer',
            'rating' => 'required|numeric',
            'usia' => 'required|integer',
            'poster' => 'mimes:jpeg,png,jpg,gif,svg|max:1000|required',
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
            $file = $request->file('poster');
            $filename = time() . '-' . uniqid() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $movies->poster = $filename;
        }
        $status = $movies->save();

        if ($status) {
            return response()->json([
                'success' => true,
                'message' => 'Movie created successfully',
                'data' => $movies,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Movie creation failed',
            ], 500);
        }
    }

    /**
     * Display the specified movie.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $movie = Movies::find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $movie,
        ]);
    }

    /**
     * Update the specified movie in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'durasi' => 'required|integer',
            'rating' => 'required|numeric',
            'usia' => 'required|integer',
            'poster' => 'mimes:jpeg,png,jpg,gif,svg|max:1000|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $movie = Movies::find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found',
            ], 404);
        }

        $movie->judul = $request->judul;
        $movie->genre = $request->genre;
        $movie->durasi = $request->durasi;
        $movie->rating = $request->rating;
        $movie->usia = $request->usia;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $filename = time() . '-' . uniqid() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $movie->poster = $filename;
        }
        $status = $movie->save();

        if ($status) {
            return response()->json([
                'success' => true,
                'message' => 'Movie updated successfully',
                'data' => $movie,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Movie update failed',
            ], 500);
        }
    }

    /**
     * Remove the specified movie from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $movie = Movies::find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found',
            ], 404);
        }

        $status = $movie->delete();

        if ($status) {
            return response()->json([
                'success' => true,
                'message' => 'Movie deleted successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Movie deletion failed',
            ], 500);
        }
    }
}