<?php

namespace App\Api\v1\Services;

use GuzzleHttp\Client;

class TranslationService
{
    private $url;

    private $host;

    private $key;

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = config('translation_service.url');
        $this->host = config('translation_service.host');
        $this->key = config('translation_service.key');
    }

    public function getWordTranslation($text, $from, $to)
    {
        $response = $this->client->request(
            'GET',
            $this->url,
            [
                'headers' => [
                    'Content-Type'    => 'application/json',
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key'  => $this->key
                ],
                'query' => [
                    'text' => $text,
                    'from' => $from,
                    'to'   => $to
                ]
            ]
        );

        return json_decode($response->getBody(), true);
    }
}
