<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'check_id',
        'text',
    ];

    /**
     * Get the parent search that owns the current search.
     */
    public function parent()
    {
        return $this->belongsTo(Search::class, 'parent_id');
    }

    /**
     * Get the checks associated with the search.
     */
    public function check()
    {
        return $this->belongsTo(Check::class);
    }
}
