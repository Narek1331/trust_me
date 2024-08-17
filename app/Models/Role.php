<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;

class Role extends Model
{
    use HasFactory, HasSlug;

    /**
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     *
     * @var bool
     */
    public $timestamps = false;

}
