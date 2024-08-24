<?php

namespace App\Filament\Resources\DesignSettingResource\Pages;

use App\Filament\Resources\DesignSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Redirect;
use App\Models\DesignSetting;
class ListDesignSettings extends ListRecords
{
    protected static string $resource = DesignSettingResource::class;

    public function mount(): void
    {
        if (DesignSetting::count() > 0) {
            $firstRecordId = DesignSetting::first()->id;
            Redirect::to(static::getResource()::getUrl('edit', ['record' => $firstRecordId]));
        } else {
            Redirect::to(static::getResource()::getUrl('create'));
        }
    }
}
