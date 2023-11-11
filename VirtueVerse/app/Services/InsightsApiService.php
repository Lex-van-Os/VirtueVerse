<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class InsightsApiService
{
    public function getBookRecommendations()
    {
        try {
            $response = Http::post('http://127.0.0.1:5000/insightsApi/bookRecommendations');
    
            if ($response->successful()) {
                return $response->json();
            } else {
                logger()->error('External API request failed with status code: ' . $response->status());
                return null;
            }
        } catch (\Exception $exception) {
            logger()->error('Error while making external API request: ' . $exception->getMessage());
            return null;
        }
    }

    public function getExpectedCompletionTime()
    {
        try {
            $response = Http::post('http://127.0.0.1:5000/insightsApi/expectedCompletionTime');
    
            if ($response->successful()) {
                return $response->json();
            } else {
                logger()->error('External API request failed with status code: ' . $response->status());
                return null;
            }
        } catch (\Exception $exception) {
            logger()->error('Error while making external API request: ' . $exception->getMessage());
            return null;
        }
    }

    public function getPopularBooks()
    {
        try {
            $response = Http::post('http://127.0.0.1:5000/insightsApi/popularBooks');
    
            if ($response->successful()) {
                return $response->json();
            } else {
                logger()->error('External API request failed with status code: ' . $response->status());
                return null;
            }
        } catch (\Exception $exception) {
            logger()->error('Error while making external API request: ' . $exception->getMessage());
            return null;
        }
    }
}