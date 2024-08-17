<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\{
    CheckService,
    ReviewTypeService,
    DomainInfoService,
    CommentService
};
class TopController extends Controller
{
    public function __construct(
        CheckService $checkService,
        ReviewTypeService $reviewTypeService,
        DomainInfoService $domainInfoService,
        CommentService $commentService
    ) {
        $this->checkService = $checkService;
        $this->reviewTypeService = $reviewTypeService;
        $this->domainInfoService = $domainInfoService;
        $this->commentService = $commentService;
    }

    public function index()
    {
        $comments = $this->commentService->getTop(100);

        return view("top",compact("comments"));
    }
}
