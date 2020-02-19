<?php

return [
    'base_uri' => env('NEWS_API_BASE_URI', 'https://newsapi.org/v1/'),
    'api_token' => env('NEWS_API_TOKEN'),
    'default_news_source' => env('DEFAULT_NEWS_SOURCE', 'CNN'),
    'default_news_source_id' => env('DEFAULT_NEWS_SOURCE_ID', 'cnn'),
];
