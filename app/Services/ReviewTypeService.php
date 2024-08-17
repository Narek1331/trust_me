<?php

namespace App\Services;
use App\Repositories\ReviewTypeRepository;
class ReviewTypeService{
    public function __construct(ReviewTypeRepository $reviewTypeRepository)
    {
        $this->reviewTypeRepository = $reviewTypeRepository;
    }

    public function getAll()
    {
        return $this->reviewTypeRepository->getAll();
    }
}
