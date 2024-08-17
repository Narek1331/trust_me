<?php

namespace App\Services\News;
use App\Repositories\News\CategoryRepository as NewsCategoryRepository;
use App\Repositories\News\NewsRepository as NewsRepository;
class CategoryService{
    public function __construct(
        NewsCategoryRepository $newsCategoryRepository,
        NewsRepository $newsRepository
        )
    {
        $this->newsCategoryRepository = $newsCategoryRepository;
        $this->newsRepository = $newsRepository;
    }

    public function getAll(int $limit = 0)
    {
        return $this->newsCategoryRepository->getAll($limit);
    }

    public function getById(int $id)
    {
        return $this->newsCategoryRepository->getById($id);
    }

}
