<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RatingResource\Pages;
use App\Filament\Resources\RatingResource\RelationManagers;
use App\Models\{
    Rating,
    ReviewType,
};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{
    TextInput,
    Select
};
use Filament\Tables\Columns\{
    TextColumn,
};
use Filament\Tables\Filters\SelectFilter;

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Оценки';

    protected static ?string $navigationGroup = 'Настройки отзыва';

    protected static ?string $pluralLabel = 'Оценки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('review_type_id')
                    ->label('Тип отзыва')
                    ->required()
                    ->options(ReviewType::get()->pluck('name','id')->toArray())
                    ->columnSpan('full'),
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Название'),
                TextColumn::make('reviewType.name')
                    ->sortable()
                    ->label('Тип отзыва'),
            ])
            ->filters([
                SelectFilter::make('reviewType')
                ->label('Тип отзыва')
                ->relationship('reviewType', 'name')
                ->options(ReviewType::get()->pluck('name','id'))
            ])
            ->actions([
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->modalHeading('Удалить')
                ]),
            ])
            ->emptyStateHeading('Не найдено')
            ->emptyStateDescription('');
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
            'index' => Pages\ListRatings::route('/'),
            'create' => Pages\CreateRating::route('/create'),
            'edit' => Pages\EditRating::route('/{record}/edit'),
        ];
    }
}
