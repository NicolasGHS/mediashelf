<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


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

    public function getStatus(int $userId, int $movieId): ?string
    {
        // Find the local movie by tmdb_id
        $localMovie = DB::table('movie')->where('tmdb_id', $movieId)->first();
        
        if (!$localMovie) {
            return null;
        }

        $record = DB::table('user_movie')
            ->where('user_id', $userId)
            ->where('movie_id', $localMovie->id)
            ->first();

        return $record ? $record->status : null;
    }

    public function updateStatus(int $userId, int $movieId, string $status): bool
    {
        try {
            // First, check if movie exists by tmdb_id
            $movieExists = DB::table('movie')->where('tmdb_id', $movieId)->exists();
            
            if (!$movieExists) {
                // Fetch movie details from TMDB and create the record
                $movieDetails = $this->findById($movieId);
                
                if ($movieDetails && !isset($movieDetails['success']) || $movieDetails['success'] !== false) {
                    DB::table('movie')->insert([
                        'tmdb_id' => $movieId,
                        'title' => $movieDetails['title'] ?? null,
                        'overview' => $movieDetails['overview'] ?? null,
                        'poster_path' => $movieDetails['poster_path'] ?? null,
                        'release_date' => isset($movieDetails['release_date']) ? $movieDetails['release_date'] : null,
                        'user_id' => $userId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    // If TMDB API fails, create minimal record
                    DB::table('movie')->insert([
                        'tmdb_id' => $movieId,
                        'user_id' => $userId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Get the local movie ID
            $localMovie = DB::table('movie')->where('tmdb_id', $movieId)->first();
            
            // Now update or insert the user_movie relationship
            DB::table('user_movie')->updateOrInsert(
                [
                    'user_id' => $userId,
                    'movie_id' => $localMovie->id
                ],
                [
                    'status' => $status,
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to update movie status: ' . $e->getMessage());
            return false;
        }
    }

    public function getUserMoviesByStatus(int $userId, string $status): array
    {
        try {
            $movies = DB::table('user_movie')
                ->join('movie', 'user_movie.movie_id', '=', 'movie.id')
                ->where('user_movie.user_id', $userId)
                ->where('user_movie.status', $status)
                ->select(
                    'movie.tmdb_id',
                    'movie.title',
                    'movie.overview',
                    'movie.poster_path',
                    'movie.release_date',
                    'user_movie.status',
                    'user_movie.updated_at as status_updated_at'
                )
                ->orderBy('user_movie.updated_at', 'desc')
                ->get();

            return $movies->toArray();
        } catch (\Exception $e) {
            Log::error('Failed to get user movies by status: ' . $e->getMessage());
            return [];
        }
    }
}