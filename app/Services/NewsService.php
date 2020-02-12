<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class NewsService
{
    public  function __construct(NewsClient $client)
    {
        $this->client = $client;
    }

    public function headlines(): Collection
    {
        //$client = new Client();
        //$response = $client->get('https://newsapi.org/v2/top-headlines?country=us&apiKey=c1b17b191d364245a82513e7a6fff71d');

        $url = 'https://newsapi.org/v2/top-headlines?country=us&apiKey=c1b17b191d364245a82513e7a6fff71d';
        try {
            $client = $this->client(['verify' => false]);
            $options = [
                'http_errors'     => true,
                'connect_timeout' => 3.14,
                'read_timeout'    => 3.14,
                'timeout'         => 3.14
            ];

            $headers = [
                'headers' => [
                    'Keep-Alive' => 'timeout=300'
                ]
            ];

            $response = $client->request('GET', $url, $headers, $options);
        } catch (ConnectException $e) {
            dd("error");
        }

        //dd($response);
        $body = json_decode($response->getBody(), true);

        //dd($body);

        return  collect($body['articles'])->map(function ($article) {
            return [
                'author' => $article['author'],
                'title' => $article['title'],
                'url' => $article['url'],
                'urlToImage' => $article['urlToImage'],
                'publishedAt' => $article['publishedAt'] !== null
                    ? Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $article['publishedAt'])
                    : 'unknown'
            ];
        });
    }
}
