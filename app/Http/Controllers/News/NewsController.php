<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\News\{
    NewsService,
    CategoryService
};

class NewsController extends Controller
{
    public function __construct(
        NewsService $newsService
        )
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        $news = $this->newsService->getAll();
    }

    public function show(int $id)
    {
        $news = $this->newsService->getById($id);
        $seo = $news->seoable;
        return view("news.show", compact("news","seo"));
    }

}
