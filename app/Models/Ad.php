<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'link',
        'img_path',
        'order_by'
    ];

    public function category()
    {
        return $this->belongsTo(AdCategory::class);
    }

}
