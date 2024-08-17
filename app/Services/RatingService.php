<?php

namespace App\Services;
use App\Repositories\RatingRepository;
class RatingService{
    public function __construct(RatingRepository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }
}
