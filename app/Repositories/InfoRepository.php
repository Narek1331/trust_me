<?php

namespace App\Repositories;

use App\Models\Info;

class InfoRepository
{
    /**
     * Find an Info record by the search term.
     *
     * @param string $search
     * @return Info|null
     */
    public function findBySearch(string $search): ?Info
    {
        return Info::where('search', $search)->first();
    }

    /**
     * Store a new Info record using only the search column.
     *
     * @param string $search
     */
    public function store(string $search)
    {
        if(!$this->findBySearch($search))
        {
            return Info::create(['search' => $search]);
        }

        return null;

    }
}
