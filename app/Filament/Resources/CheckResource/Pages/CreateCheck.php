<?php

namespace App\Filament\Resources\CheckResource\Pages;

use App\Filament\Resources\CheckResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCheck extends CreateRecord
{
    protected static string $resource = CheckResource::class;

    public function getTitle(): string
    {
        return 'Создать';
    }
}
