<?php

namespace App\Api\v1\Services;

use GuzzleHttp\Client;

class WordsAPIService
{
    private $url;

    private $host;

    private $key;

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = config('words_api_service.url');
        $this->host = config('words_api_service.host');
        $this->key = config('words_api_service.key');
    }

    public function getWordDefinition($word)
    {
        $response = $this->client->request(
            'GET',
            $this->url . '/' . $word . '/definitions',
            [
                'headers' => [
                    'Content-Type'    => 'application/json',
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key'  => $this->key
                ]
            ]
        );

        $definitions = json_decode($response->getBody(), true);

        if (empty($definitions)) {
            return __('bot_labels.definition_for_this_word_do_not_found');
        }

        $result_definitions = '';

        foreach ($definitions['definitions'] as $key => $definition) {
            $result_definitions .=
                ($key + 1) . ')' .
                '  ' . __('bot_labels.definition_text') . '    => ' . $definition['definition'] . PHP_EOL .
                '     ' . __('bot_labels.part_of_speech') . ' => ' . $definition['partOfSpeech'] . PHP_EOL;
        }

        return $result_definitions;
    }

    public function getWordSynonyms($word)
    {
        $response = $this->client->request(
            'GET',
            $this->url . '/' . $word . '/synonyms',
            [
                'headers' => [
                    'Content-Type'    => 'application/json',
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key'  => $this->key
                ]
            ]
        );

        $synonyms = json_decode($response->getBody(), true);

        if (empty($synonyms)) {
            return __('bot_labels.synonyms_for_this_word_do_not_found');
        }

        $result_synonyms = '';

        foreach ($synonyms['synonyms'] as $key => $synonym) {
            $result_synonyms .=
                ($key + 1) . ') ' . $synonym . PHP_EOL;
        }

        return $result_synonyms;
    }

    public function getWordAntonyms($word)
    {
        $response = $this->client->request(
            'GET',
            $this->url . '/' . $word . '/antonyms',
            [
                'headers' => [
                    'Content-Type'    => 'application/json',
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key'  => $this->key
                ]
            ]
        );

        $antonyms = json_decode($response->getBody(), true);

        if (empty($antonyms)) {
            return __('bot_labels.antonyms_for_this_word_do_not_found');
        }

        $result_antonyms = '';

        foreach ($antonyms['antonyms'] as $key => $antonym) {
            $result_antonyms .=
                ($key + 1) . ') ' . $antonym . PHP_EOL;
        }

        return $result_antonyms;
    }

    public function getWordRhymes($word)
    {
        $response = $this->client->request(
            'GET',
            $this->url . '/' . $word . '/rhymes',
            [
                'headers' => [
                    'Content-Type'    => 'application/json',
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key'  => $this->key
                ]
            ]
        );

        $rhymes = json_decode($response->getBody(), true);

        if (empty($rhymes)) {
            return __('bot_labels.rhymes_for_this_word_do_not_found');
        }

        return $rhymes;
    }
}
