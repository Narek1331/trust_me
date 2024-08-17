<?php

namespace App\Repositories\News;
use App\Models\News\{
    News,
    NewsCategory
};

class NewsRepository{
    public function getAll()
    {
        return News::get();
    }

    public function getById(int $id)
    {
        return News::with('seoable')->findOrFail($id);

    }

}
