<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seo;
class News extends Model
{
    use HasFactory;

     /**
     *
     * @var string
     */
    protected $table = 'news';

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'text',
        'img_path'
    ];

    /**
     *
     * @var bool
     */

    public function category()
    {
        return $this->belongsTo(NewsCategory::class,'category_id','id');
    }

     /**
     * Связь "один к одному" с таблицей seoables
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seoable()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

}
