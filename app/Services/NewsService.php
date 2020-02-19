<?php

namespace App\Services;

use App\Http\Clients\NewsClient;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class NewsService
{
    /**
     * @var NewsClient
     */
    private $client;

    public  function __construct(NewsClient $client)
    {
        $this->client = $client;
    }

    public function allSources()
    {
        $response = $this->client->get('sources?');

        $allSources =  json_decode($response->getBody(), true);

        return  $allSources['sources'];
    }

    public function headlines($source): Collection
    {
        $response = $this->client->get('articles?source='.$source);

        $body = json_decode($response->getBody(), true);

        return  collect($body['articles'])->map(function ($article) {
            return [
                'author' => $article['author'],
                'title' => $article['title'],
                'description' => $article['description'],
                'url' => $article['url'],
                'urlToImage' => $article['urlToImage'],
                'publishedAt' => $article['publishedAt'] !== null
                    ? Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $article['publishedAt'])
                    : 'unknown'
            ];
        });
    }
}
