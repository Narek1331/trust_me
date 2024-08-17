<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckResource\Pages;
use App\Filament\Resources\CheckResource\RelationManagers;
use App\Models\Check;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{
    TextInput,
    Select,
    FileUpload
};
use Filament\Tables\Columns\{
    TextColumn,
    ImageColumn,
};
use Filament\Tables\Filters\SelectFilter;

class CheckResource extends Resource
{
    protected static ?string $model = Check::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static ?string $navigationLabel = 'Проверки';

    protected static ?string $navigationGroup = 'Основной';

    protected static ?string $pluralLabel = 'Проверки';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->maxLength(255)
                ->label('Название')
                ->required()
                ->columnSpan('full'),
            FileUpload::make('logo_path')
                ->label('Логотип')
                ->directory(function () {
                    return "/logo";
                })
                ->columnSpan('full'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order_by')
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Название'),
                ImageColumn::make('logo_path')
                    ->label('Логотип')
                    ->size(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->modalHeading('Удалить')
                ]),
            ])
            ->defaultSort('order_by', 'asc')
            ->emptyStateHeading('Не найдено')
            ->emptyStateDescription('');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ChildrenChecksRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('parent_id', null);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChecks::route('/'),
            'create' => Pages\CreateCheck::route('/create'),
            'edit' => Pages\EditCheck::route('/{record}/edit'),
        ];
    }
}
