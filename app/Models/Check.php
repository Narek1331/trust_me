<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;

class Check extends Model
{
    use HasFactory, HasSlug;

    /**
     *
     * @var string
     */
    protected $table = 'checks';

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'url',
        'logo_path',
        'order_by',
    ];

    /**
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the child checks for the current check.
     */
    public function childrenChecks()
    {
        return $this->hasMany(Check::class, 'parent_id');
    }

    /**
     * Get the parent check for the current check.
     */
    public function parentCheck()
    {
        return $this->belongsTo(Check::class, 'parent_id');
    }
}
