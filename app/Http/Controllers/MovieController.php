<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MovieApiService;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected $movieApi;

    public function __construct(MovieApiService $movieApi)
    {
        $this->movieApi = $movieApi;
    }

    public function getMovieById($id) 
    {
        $movie = $this->movieApi->findById($id);
        return $movie;
    }

    public function search(Request $request) 
    {
        $query = $request->input('query');
        $movies = $this->movieApi->searchMovies($query);

        return response()->json($movies);
    }

    public function save(Request $request) 
    {
        $movieData = $request->only(['title', 'description', 'release_date', 'image']);

        // save in db
        $movie = auth()->user()->movies()->create($movieData);

        return response()->json($movie);
    }

   public function getImagePath(Request $request) 
    {
        $response = $this->movieApi->getImagePath();
        return $response;
    }

    public function getWatchStatus(Request $request, $movieId)
    {
        $userId = auth()->id();
        
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $status = $this->movieApi->getStatus($userId, $movieId);

        return response()->json([
            'user_id' => $userId,
            'movie_id' => $movieId,
            'status' => $status
        ]);
    }

    public function updateWatchStatus(Request $request, $movieId)
    {
        $userId = auth()->id();
        
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $request->validate([
            'status' => 'required|in:want_to_watch,watched'
        ]);

        $status = $request->input('status');

        // Use the service to update the status
        $result = $this->movieApi->updateStatus($userId, $movieId, $status);

        return response()->json([
            'user_id' => $userId,
            'movie_id' => $movieId,
            'status' => $status,
            'success' => $result
        ]);
    }

}