<?php

namespace App\Services;

use App\Repositories\SearchRepository;

class SearchService
{
    /**
     * @var \App\Repositories\SearchRepository
     */
    protected $searchRepository;

    /**
     * SearchService constructor.
     *
     * @param \App\Repositories\SearchRepository $searchRepository
     */
    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    /**
     * Store a new search.
     *
     * @param array $data
     * @return \App\Models\Search
     */
    public function store(array $data)
    {
        return $this->searchRepository->store($data);
    }

    /**
     * Get searches.
     *
     * @return \App\Models\Search
     */
    public function get()
    {
        return $this->searchRepository->get();
    }

    /**
     * Get searches by text.
     *
     * @return \App\Models\Search
     */
    public function getByText(string $text)
    {
        return $this->searchRepository->getByText($text);
    }
}
