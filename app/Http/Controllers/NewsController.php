<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  NewsService               $newsService
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, NewsService $newsService)
    {
        $response['newsSources'] = $newsService->allSources();

        if ($request->isMethod('get')) {
            $response['sourceName'] = config('news.default_news_source');
            $response['sourceId'] = config('news.default_news_source_id');

        } else {
            $request->validate([
                'source' => 'required|string',
            ]);

            $split_input = explode(':', $request->source);
            $response['sourceId'] = trim($split_input[0]);
            $response['sourceName'] = trim($split_input[1]);
        }

        $response['news'] = $newsService->headlines($response['sourceId']);

        return view('news', compact('response'));
    }
}
