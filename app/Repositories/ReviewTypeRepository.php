<?php

namespace App\Repositories;
use App\Models\ReviewType;

class ReviewTypeRepository{
    public function getAll()
    {
        return ReviewType::with('ratings')->get();
    }
}
