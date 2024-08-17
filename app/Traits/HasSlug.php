<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait and add model event listeners.
     */
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            if(!$model->slug)
            {
                $model->slug = $model->generateSlug();
            }
        });

        static::updating(function ($model) {
            if (!$model->slug && ($model->isDirty('name') || $model->isDirty('title'))) {
                $model->slug = $model->generateSlug();
            }
        });
    }

    /**
     * Generate a slug from the model's name or title.
     *
     * @return string
     */
    protected function generateSlug()
    {
        return Str::slug($this->name ?? $this->title ?? 'default_slug' . now()->timestamp,'_');
    }
}
