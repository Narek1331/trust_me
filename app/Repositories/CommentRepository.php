<?php

namespace App\Repositories;
use App\Models\Comment;

class CommentRepository{
    public function store(
        $search,
        $user_id,
        $review_type_id,
        $check_id,
        $text = null
    )
    {
        return Comment::create([
            'search' => $search,
            'user_id' => $user_id,
            'review_type_id' => $review_type_id,
            'check_id' => $check_id,
            'text' => $text,
        ]);
    }

    public function getBySearchAndCheckId(string $search,int $checkId)
    {
        return Comment::where('search', $search)
        ->with(['positiveRates','negativeRates'])
        ->where('check_id',$checkId)
        ->get();
    }

    public function getTop(int $limit = 0)
    {
        $comments =  Comment::query()
        ->with([
            'positiveRates',
            'negativeRates',
            'check'
        ])
        ->whereHas('check',function($q){
            return $q->where('slug', 'site');
        });

        if($limit>0)
        {
            $comments = $comments->limit($limit);
        }

        $comments = $comments->get();

        $newArray = [];

        foreach($comments as $comment)
        {
            $rateCount = 0;

            $positiveRatesCount = $comment->positiveRates()->count();
            $negativeRatesCount = $comment->negativeRates()->count();

            $rateCount += $positiveRatesCount;

            if($rateCount > 0)
            {
                $rateCount -= $negativeRatesCount;
            }

            if($comment->reviewType()->exists())
            {
                if($comment->reviewType->slug == 'positive')
                {
                    $rateCount += 1;
                }else if($comment->reviewType->slug == 'negative')
                {
                    if($rateCount > 0)
                    {
                        $rateCount -= 1;
                    }
                }
            }

            if(!isset($newArray[$comment['search']]))
            {
                $newArray[$comment['search']] = 0;
            }

            $newArray[$comment['search']] += $rateCount;

        }

        if($newArray && count($newArray))
        {
            $collection = collect($newArray);

            // Sort the collection by values in ascending order
            $sortedCollection = $collection->sortDesc();

            // Convert the sorted collection back to an array
            $sortedSites = $sortedCollection->all();

            // Print the sorted array
            return $sortedSites;
        }

        return [];


    }
}
