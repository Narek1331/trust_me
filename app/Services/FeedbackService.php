<?php

namespace App\Services;

use App\Repositories\FeedbackRepository;
use App\Models\Feedback;

/**
 * Class FeedbackService
 *
 * @package App\Services
 */
class FeedbackService
{
    protected $feedbackRepository;

    /**
     * FeedbackService constructor.
     *
     * @param FeedbackRepository $feedbackRepository
     */
    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * Store a new feedback.
     *
     * @param array $data
     * @return Feedback
     */
    public function store(array $data): Feedback
    {
        // You can add additional business logic here if needed
        return $this->feedbackRepository->store($data);
    }
}
