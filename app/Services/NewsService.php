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

    public function headlines(): Collection
    {
        //dd(openssl_get_cert_locations());

        $response = $this->client->get('top-headlines?country=us');

        /*$client = new Client([ 'verify' => false ]);
        $response = $client->get('https://newsapi.org/v2/top-headlines?country=us&apiKey=c1b17b191d364245a82513e7a6fff71d');*/


        //dd($response);
        $body = json_decode($response->getBody(), true);

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
