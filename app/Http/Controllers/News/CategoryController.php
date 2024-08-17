<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\News\CategoryService;

class CategoryController extends Controller
{
    public function __construct(
        CategoryService $categoryService
        )
    {
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $newsCategories = $this->categoryService->getAll();
        return view("category.index",compact("newsCategories"));
    }

    public function show($id)
    {
        $newsCategory = $this->categoryService->getById($id);
        return view("category.show",compact("newsCategory"));
    }

}
