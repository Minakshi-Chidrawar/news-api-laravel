<?php

namespace Tests\Feature;

use App\Http\Clients\NewsClient;
use App\Services\NewsService;
use Carbon\Carbon;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\Support\WorksWithNewsClient;
use Tests\TestCase;

class NewsServiceTest extends TestCase
{
    use WorksWithNewsClient;

    /**
     * @var NewsService
     */
    private $newsService;
    /**
     * @var MockHandler
     */
    private $mockHandler;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockHandler = $this->swapNewsClient();

        $this->newsService = app(NewsService::class);
    }

    /** @test */
    public function fetch_headlines()
    {
        $this->mockHandler->append($this->mockSingleArticleResponse());
        $response = $this->newsService->headlines();

        $this->assertCount(1, $response);

        $this->assertEquals('Megan Canon', $response[0]['author']);
        $this->assertInstanceOf(Carbon::class, $response[0]['publishedAt']);
    }
}
