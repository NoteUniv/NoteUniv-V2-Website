<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiController extends Controller
{

    public function getApiData()
    {
        $client = new Client();
        try {
            $response = $client->get('https://color.quentium.fr/random', [
                'headers' => ['User-Agent' => 'NoteUniv API'],
                'verify' => false,
            ]);
            $data = $response->getBody()->getContents();
            $json = json_decode($data, true);
            $collection = collect($json);
            return $collection[0];
        } catch (RequestException $e) {
            return [
                'hexCode' => '#0dead0',
                'bestName' => 'Dead API (this is not a name, the API is really dead 😭)',
            ];
        }
    }
}
