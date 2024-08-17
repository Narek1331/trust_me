<?php

namespace App\Repositories;

use App\Models\Feedback;

/**
 * Class FeedbackRepository
 *
 * @package App\Repositories
 */
class FeedbackRepository
{
    /**
     * Store a new feedback in the repository.
     *
     * @param array $data
     * @return Feedback
     */
    public function store(array $data): Feedback
    {
        return Feedback::create($data);
    }
}
