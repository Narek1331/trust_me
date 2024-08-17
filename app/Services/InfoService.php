<?php

namespace App\Services;

use App\Repositories\InfoRepository;
use App\Models\Info;

class InfoService
{
    /**
     * @var InfoRepository
     */
    protected $infoRepository;

    /**
     * InfoService constructor.
     *
     * @param InfoRepository $infoRepository
     */
    public function __construct(InfoRepository $infoRepository)
    {
        $this->infoRepository = $infoRepository;
    }

    /**
     * Find an Info record by the search term.
     *
     * @param string $search
     * @return Info|null
     */
    public function findBySearch(string $search): ?Info
    {
        return $this->infoRepository->findBySearch($search);
    }

    /**
     * Store a new Info record using only the search column if it does not already exist.
     *
     * @param string $search
     * @return Info|null
     */
    public function store(string $search): ?Info
    {
        return $this->infoRepository->store($search);
    }
}
