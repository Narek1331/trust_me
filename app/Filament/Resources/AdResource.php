<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Filament\Resources\AdResource\RelationManagers;
use App\Models\{
    Ad,
    AdCategory
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
    Select,
    Textarea,
    FileUpload
};
use Filament\Tables\Columns\{
    TextColumn,
};
use Filament\Tables\Filters\SelectFilter;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'Реклама';

    protected static ?string $navigationGroup = 'Продвижение';

    protected static ?string $pluralLabel = 'Реклама';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->label('Категория')
                    ->options(AdCategory::get()->pluck('name','id'))
                    ->required()
                    ->reactive()
                    ->columnSpan('full'),
                FileUpload::make('img_path')
                    ->label('Изображение')
                    ->directory(function () {
                        return "/ads";
                    })
                    ->columnSpan('full'),
                TextInput::make('title')
                    ->maxLength(255)
                    ->label('Заголовок')
                    ->columnSpan('full'),
                TextInput::make('link')
                    ->maxLength(255)
                    ->url()
                    ->label('Ссылка')
                    ->columnSpan('full'),
                Textarea::make('description')
                    ->label('Описание')
                    ->rows(10)
                    ->cols(20)
                    ->maxLength(65000)
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order_by')
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label('Категория'),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Заголовок'),
                TextColumn::make('link')
                    ->label('Ссылка'),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                ->label('Категория')
                ->options(AdCategory::get()->pluck('name','id'))
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редактировать'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Удалить'),
                ]),
            ])
            ->defaultSort('order_by', 'asc')
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
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}
