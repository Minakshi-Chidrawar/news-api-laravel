<?php


namespace Tests\Support;


use App\Http\Clients\NewsClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

trait WorksWithNewsClient
{
    public function swapNewsClient(): MockHandler
    {
        $mockHandler = new MockHandler();

        $client = new NewsClient([
            'handler' => HandlerStack::create($mockHandler)
        ]);

        $this->app->instance(NewsClient::class, $client);

        return $mockHandler;
    }

    public function mockSingleArticleResponse(): Response
    {
        return new Response(200, [], json_encode([
            'status' => 'ok',
            'totalResults' => 38,
            'articles' => [
                [
                    'source' => [
                        'id' => 'the-washington-post',
                        'name' => 'The Washington Post'
                    ],

                    'author' => 'Megan Canon',
                    'title' => 'Live updates: Coronavirus cases surge again in China; more than 1700 medical workers infected - The Washington Post',
                    'description' => "Valentine’s Day flower sellers are the latest economic casualties of the deadly epidemic.",
                    'url' => 'https://www.washingtonpost.com/world/asia_pacific/coronavirus-china-live-updates/2020/02/14/6806aa08-4eb8-11ea-b721-9f4cdc90bc1c_story.html',
                    'urlToImage' => 'https://www.washingtonpost.com/resizer/E8thUYBRLMEM_6EpBwXpU0HVX5g=/1440x0/smart/arc-anglerfish-washpost-prod-washpost.s3.amazonaws.com/public/SJNOBHCO7MI6VH2RVCCIYNX4DQ.jpg',
                    'publishedAt' => '2020-02-14T20:12:00Z',
                    'content' => 'BEIJING Chinese authorities in Nanjing have asked residents'
                ],
            ],
        ]));
    }
}
