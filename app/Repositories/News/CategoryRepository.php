<?php

namespace App\Repositories\News;
use App\Models\News\{
    News,
    NewsCategory
};

class CategoryRepository{
    public function getAll(int $limit = 0)
    {
        $newsCategories =  NewsCategory::query();

        if($limit)
        {
            $newsCategories->limit($limit);
        }

        return $newsCategories->get();

    }

    public function getById(int $id)
    {
        return NewsCategory::with('news')
        ->findOrFail($id);
    }

}
