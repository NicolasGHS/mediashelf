<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class MovieApiService 
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('MOVIE_API_KEY');
        $this->baseUrl = "https://api.themoviedb.org/3";
    }

    public function findById($id)
    {
        $response = Http::get($this->baseUrl."/movie/".$id, [
            'api_key' => $this->apiKey
        ]);

        return $response->json();
    }

    public function searchMovies(string $query, int $page = 1)
    {
        $response = Http::get("{$this->baseUrl}/search/movie", [
            'api_key' => $this->apiKey,
            'query' => $query,
            'page' => $page
        ]);
        return $response->json();
    }

    public function getMovieDetails(int $movieId): mixed 
    {
        $response = Http::get("{$this->baseUrl}/movie/{$movieId}", [
            'api_key' => $this->apiKey,
        ]);
        return $response->json();
    }

    public function getImagePath()
    {
        // $response = Http::get("{$this->baseUrl}/configuration", [
        //     'api_key' => $this->apiKey,
        // ]);

        // $data = $response->json();
        // return $data;
        $url = "https://image.tmdb.org/t/p/w92/";
        return $url;

    }
}