<?php

namespace App\Services\News;
use App\Repositories\News\CategoryRepository as NewsCategoryRepository;
use App\Repositories\News\NewsRepository as NewsRepository;
class NewsService{
    public function __construct(
        NewsCategoryRepository $newsCategoryRepository,
        NewsRepository $newsRepository
        )
    {
        $this->newsCategoryRepository = $newsCategoryRepository;
        $this->newsRepository = $newsRepository;
    }

    public function getAll()
    {
        return $this->newsRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->newsRepository->getById($id);
    }

}
