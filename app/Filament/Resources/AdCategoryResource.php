<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdCategoryResource\Pages;
use App\Filament\Resources\AdCategoryResource\RelationManagers;
use App\Models\AdCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{
    TextInput,
    Fieldset,
    Toggle
};
use Filament\Tables\Columns\{
    TextColumn,
    ToggleColumn,
};

class AdCategoryResource extends Resource
{
    protected static ?string $model = AdCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-up-down';

    protected static ?string $navigationLabel = 'Категории реклама';

    protected static ?string $navigationGroup = 'Продвижение';

    protected static ?string $pluralLabel = 'Категории реклама';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // TextInput::make('name')
                //     ->required()
                //     ->maxLength(255)
                //     ->label('Заголовок')
                //     ->columnSpan('full'),
                Toggle::make('status')
                    ->default(true)
                    ->columnSpan('full')
                    ->label('Статус'),
                Fieldset::make('Размер раздела')
                ->schema([
                    TextInput::make('width')
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->maxLength(255)
                        ->label('Ширина')
                        ->columnSpan('full'),
                    TextInput::make('height')
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->maxLength(255)
                        ->label('Высота')
                        ->columnSpan('full'),
                ])
                ->columns(2)
                ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('status')
                    ->label('Статус'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Заголовок'),
                TextColumn::make('width')
                    ->label('Ширина'),
                TextColumn::make('height')
                    ->label('Высота')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdCategories::route('/'),
            'edit' => Pages\EditAdCategory::route('/{record}/edit'),
        ];
    }
}
