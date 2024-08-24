<?php

namespace App\Filament\Resources\DesignSettingResource\Pages;

use App\Filament\Resources\DesignSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\ButtonAction;

class EditDesignSetting extends EditRecord
{
    protected static string $resource = DesignSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

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
            ButtonAction::make('save')
                ->label('Сохранить')
                ->action('save'),
        ];
    }
}
