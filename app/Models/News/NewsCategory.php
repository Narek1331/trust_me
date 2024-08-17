<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;

     /**
     *
     * @var string
     */
    protected $table = 'news_categories';

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'img_path'
    ];

    public function news()
    {
        return $this->hasMany(News::class,'category_id','id');
    }
}
