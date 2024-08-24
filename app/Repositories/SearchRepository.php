<?php

namespace App\Repositories;

use App\Models\Search;

class SearchRepository
{
    /**
     * Store a new search in the database.
     *
     * @param array $data
     * @return \App\Models\Search
     */
    public function store(array $data): Search
    {
        return Search::create($data);
    }

    /**
     * Find a search by its ID.
     *
     * @param int $id
     * @return \App\Models\Search|null
     */
    public function findById(int $id): ?Search
    {
        return Search::find($id);
    }

     /**
     * Get searches.
     *
     * @return \App\Models\Search
     */
    public function get()
    {
        return Search::orderBy('created_at','desc')->get();
    }

    /**
     * Get searches by text.
     *
     * @return \App\Models\Search
     */
    public function getByText(string $text)
    {
        return Search::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->where('text',$text)
        ->get();
    }
}
