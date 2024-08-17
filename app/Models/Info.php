<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

     /**
     *
     * @var string
     */
    protected $table = 'infos';

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'search',
        'img_path',
        'description',
    ];

    /**
     *
     * @var bool
     */
    public $timestamps = true;
}
