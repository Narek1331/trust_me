<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;

class ReviewType extends Model
{
    use HasFactory, HasSlug;

    /**
     *
     * @var string
     */
    protected $table = 'review_types';

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     *
     * @var bool
     */
    public $timestamps = false;

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
