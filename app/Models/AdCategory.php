<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;

class AdCategory extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'ad_categories';

    protected $fillable = [
        'name',
        'slug',
        'width',
        'height',
        'status',
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class,'category_id','id');
    }
}
