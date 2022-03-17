<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class ApiController extends Controller
{

    public function getApiData()
    {
        $client = new Client();
        $response = $client->get('https://color.quentium.fr/random', [
            'headers' => ['User-Agent' => 'NoteUniv API'],
            'verify' => false,
        ]);
        $array = $response->getBody()->getContents();
        $json = json_decode($array, true);
        $collection = collect($json);
        return $collection[0];
    }
}
