<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FeedbackService;
use App\Http\Requests\Feedback\Store as FeedbackStoreRequest;
/**
 * Class FeedbackController
 *
 * @package App\Http\Controllers
 */
class FeedbackController extends Controller
{
    /**
     * @var FeedbackService
     */
    protected $feedbackService;

    /**
     * FeedbackController constructor.
     *
     * @param FeedbackService $feedbackService
     */
    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    /**
     * Store a new feedback.
     *
     * @param FeedbackStoreRequest $request
     */
    public function store(FeedbackStoreRequest $request)
    {
        $feedback = $this->feedbackService->store($request->all());

        return redirect()->back();
    }
}
