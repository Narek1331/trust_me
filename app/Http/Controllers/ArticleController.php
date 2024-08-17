<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckService;
use App\Services\News\CategoryService as NewsCategoryService;

class ArticleController extends Controller
{
    public function __construct(
        CheckService $checkService,
        NewsCategoryService $newsCategoryService
        )
    {
        $this->checkService = $checkService;
        $this->newsCategoryService = $newsCategoryService;
    }
    public function index()
    {
        $checks = $this->checkService->getAllWithChilds();
        $newsCategories = $this->newsCategoryService->getAll(9);
        return view("welcome",compact('checks','newsCategories'));
    }
}
