<?php

namespace App\Services;
use App\Repositories\CommentRepository;
class CommentService{
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(array $data)
    {
        $comment = $this->commentRepository->store(
            $data['search'],
            auth()->user()->id,
            $data['review_type_id'],
            $data['check_id'],
            $data['text']
        );

        if(isset($data['positive']) && count($data['positive']))
        {
            $comment->positiveRates()->sync($data['positive']);
        }

        if(isset($data['negative']) && count($data['negative']))
        {
            $comment->negativeRates()->sync($data['negative']);
        }

        return $comment;
    }

    public function getBySearchAndCheckId(string $search,int $checkId)
    {
        return $this->commentRepository->getBySearchAndCheckId($search,$checkId);
    }

    public function getTop(int $limit = 0)
    {
        return $this->commentRepository->getTop($limit);
    }
}
