<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    /**
     * @var string
     */
    protected $table = 'seoables';

    /**
     * @var array
     */
    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    public $timestamps = true;


    /**
     * Полиморфное отношение
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function seoable()
    {
        return $this->morphTo();
    }
}
