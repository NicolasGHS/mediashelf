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
        $config = $this->movieApi->getImagePath();
        return response()->json($config);
    }
    
}