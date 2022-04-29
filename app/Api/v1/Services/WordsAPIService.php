<?php

namespace App\Api\v1\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WordsAPIService
{
    private $url;

    private $host;

    private $key;

    private Client $client;

    private $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = config('words_api_service.url');
        $this->host = config('words_api_service.host');
        $this->key = config('words_api_service.key');
        $this->headers = [
            'Content-Type'    => 'application/json',
            'x-rapidapi-host' => $this->host,
            'x-rapidapi-key'  => $this->key
        ];
    }

    public function getWordDefinition($word)
    {
        $response = $this->client->request(
            'GET',
            $this->url . '/' . $word . '/definitions',
            [
                'headers' => $this->headers
            ]
        );

        $definitions = json_decode($response->getBody(), true);

        if (empty($definitions['definitions'])) {
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
                'headers' => $this->headers
            ]
        );

        $synonyms = json_decode($response->getBody(), true);

        if (empty($synonyms['synonyms'])) {
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
                'headers' => $this->headers
            ]
        );

        $antonyms = json_decode($response->getBody(), true);

        if (empty($antonyms['antonyms'])) {
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
                'headers' => $this->headers
            ]
        );

        $rhymes = json_decode($response->getBody(), true);

        if (empty($rhymes)) {
            return __('bot_labels.rhymes_for_this_word_do_not_found');
        }

        return $rhymes;
    }

    public function getWordPronunciation($word)
    {
        $response = $this->client->request(
            'GET',
            $this->url . '/' . $word . '/pronunciation',
            [
                'headers' => $this->headers
            ]
        );

        $pronunciation = json_decode($response->getBody(), true);

        if (empty($pronunciation['pronunciation'])) {
            return __('bot_labels.pronunciation_for_this_word_do_not_found');
        }

        $result_pronunciation = '';

        foreach ($pronunciation['pronunciation'] as $key => $item) {
            $result_pronunciation.= __('bot_labels.pronunciation_' . $key) . ' : ' . $item . PHP_EOL;
        }

        return $result_pronunciation;
    }

    public function getWordSyllables($word)
    {
        $response = $this->client->request(
            'GET',
            $this->url . '/' . $word . '/syllables',
            [
                'headers' => $this->headers
            ]
        );

        $syllables = json_decode($response->getBody(), true);

        if (empty($syllables['syllables']['list'])) {
            return __('bot_labels.syllables_for_this_word_do_not_found');
        }

        $result_syllables = '';

        foreach ($syllables['syllables']['list'] as $key => $item) {
            $result_syllables .=
                ($key + 1) . ') ' . $item . PHP_EOL;
        }

        return $result_syllables;
    }

    //Returns zipf, ;
    //perMillion, ;
    //and diversity, .

    public function getWordFrequency($word)
    {
        $response = $this->client->request(
            'GET',
            $this->url . '/' . $word . '/frequency',
            [
                'headers' => $this->headers
            ]
        );

        $frequency = json_decode($response->getBody(), true);

        if (empty($frequency['frequency'])) {
            return __('bot_labels.frequency_for_this_word_do_not_found');
        }

        $result_frequency = '';

        foreach ($frequency['frequency'] as $key => $item) {
            $result_frequency .= $key . ' - ' . $item . PHP_EOL;
        }
        $result_frequency .= PHP_EOL;

        $result_frequency .= '*zipf - ' . __('bot_labels.frequency_zipf') . PHP_EOL;
        $result_frequency .= '*perMillion - ' . __('bot_labels.frequency_perMillion') . PHP_EOL;
        $result_frequency .= '*diversity - ' . __('bot_labels.frequency_diversity') . PHP_EOL;

        return $result_frequency;
    }

    public function getRandomWord()
    {
        $response = $this->client->request(
            'GET',
            $this->url . '/?random=true',
            [
                'headers' => $this->headers
            ]
        );

        $random_word = json_decode($response->getBody(), true);

        return $random_word['word'];
    }
}
