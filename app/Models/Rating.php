<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

     /**
     *
     * @var string
     */
    protected $table = 'ratings';

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'review_type_id'
    ];

    /**
     *
     * @var bool
     */
    public $timestamps = false;

    public function reviewType()
    {
        return $this->belongsTo(ReviewType::class);
    }
}
