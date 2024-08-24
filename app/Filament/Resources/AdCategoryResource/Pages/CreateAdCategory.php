<?php

namespace App\Filament\Resources\AdCategoryResource\Pages;

use App\Filament\Resources\AdCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdCategory extends CreateRecord
{
    protected static string $resource = AdCategoryResource::class;

    public function getTitle(): string
    {
        return 'Создать';
    }
}
