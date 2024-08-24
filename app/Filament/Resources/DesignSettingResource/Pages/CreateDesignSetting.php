<?php

namespace App\Filament\Resources\DesignSettingResource\Pages;

use App\Filament\Resources\DesignSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Pages\Actions\CreateAction;
class CreateDesignSetting extends CreateRecord
{
    protected static string $resource = DesignSettingResource::class;

    public function getTitle(): string
    {
        return 'Дизайн';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        return [
            CreateAction::make()
                ->label('Сохранить')
                ->action('create'),
        ];
    }
}
