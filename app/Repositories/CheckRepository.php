<?php

namespace App\Repositories;
use App\Models\Check;

class CheckRepository{
    public function getAllWithChilds()
    {
        return Check::where('parent_id',null)
        ->with('childrenChecks')
        ->get();
    }

    public function getBySlug(string $slug)
    {
        return Check::where('slug',$slug)
        ->with('parentCheck')
        ->first();
    }
}
