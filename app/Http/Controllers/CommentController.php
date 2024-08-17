<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Requests\Comment\StoreRequest as CommentStoreRequest;

class CommentController extends Controller
{
    public function __construct(
        CommentService $commentService
    ){
        $this->commentService = $commentService;
    }

    public function store(CommentStoreRequest $request)
    {
        $comment = $this->commentService->store($request->all());
        return redirect()->back();
    }
}
