<?php

namespace App\Repositories;
use App\Models\Rating;

class RatingRepository{
    public function getAll()
    {
        return Rating::get();
    }
}
