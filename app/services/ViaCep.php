<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCep
{
    public static function GetCep($cep)
    {
        $url = "https://viacep.com.br/ws/{$cep}/json/";
        $response = Http::get($url);
        return $response->json();
    }
}
