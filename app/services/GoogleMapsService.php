<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleMapsService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.key');
    }

    public function getDistance($origin, $destination)
    {
        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json';
        $data = [
            'origins' => $origin,
            'destinations' => $destination,
            'key' => $this->apiKey,
            'mode' => 'driving', // walking, bicycling, transit
            'language' => 'pt-BR',
        ];

        $response = Http::get($url, $data);
        return $response->json();
    }
}
