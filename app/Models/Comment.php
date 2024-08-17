<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReviewType;
class Comment extends Model
{
    use HasFactory;

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'search',
        'user_id',
        'review_type_id',
        'check_id',
        'text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewType()
    {
        return $this->hasOne(ReviewType::class,'id','review_type_id');
    }

    public function check()
    {
        return $this->hasOne(Check::class,'id','check_id');
    }

    public function positiveRates()
    {
        $positiveReviewType = ReviewType::where('slug', 'positive')->firstOrFail();

        return $this->belongsToMany(Rating::class, 'comment_positive_rating')
        ->where('ratings.review_type_id', $positiveReviewType->id);

    }

    public function negativeRates()
    {
        $negativeReviewType = ReviewType::where('slug', 'negative')->firstOrFail();

        return $this->belongsToMany(Rating::class, 'comment_negative_rating')
        ->where('ratings.review_type_id', $negativeReviewType->id);
    }

}
