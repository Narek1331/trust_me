<?php

namespace App\Filament\Resources\AdCategoryResource\Pages;

use App\Filament\Resources\AdCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdCategory extends EditRecord
{
    protected static string $resource = AdCategoryResource::class;

    public function getTitle(): string
    {
        $record = $this->getRecord();
        return $record->name;
    }
}
