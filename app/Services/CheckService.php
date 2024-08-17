<?php

namespace App\Services;
use App\Repositories\CheckRepository;
use App\Models\Check;
class CheckService{
    public function __construct(CheckRepository $checkRepository)
    {
        $this->checkRepository = $checkRepository;
    }

    public function getAllWithChilds()
    {
        return $this->checkRepository->getAllWithChilds();
    }

    public function getBySlug(string $slug)
    {
        return $this->checkRepository->getBySlug($slug);
    }
}
