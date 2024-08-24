<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DesignSettingResource\Pages;
use App\Filament\Resources\DesignSettingResource\RelationManagers;
use App\Models\DesignSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{
    FileUpload,
};
class DesignSettingResource extends Resource
{
    protected static ?string $model = DesignSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationLabel = 'Дизайн';

    protected static ?string $navigationGroup = 'Настройки';

    protected static ?string $pluralLabel = 'Дизайн';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('logo_path')
                ->label('Логотип')
                ->directory(function () {
                    return "/main_logo";
                })
                ->columnSpan('full'),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDesignSettings::route('/'),
            'create' => Pages\CreateDesignSetting::route('/create'),
            'edit' => Pages\EditDesignSetting::route('/{record}/edit'),
        ];
    }
}
