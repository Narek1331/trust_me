<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News\{
    News,
    NewsCategory
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
    ImageColumn
};
use Filament\Forms\Components\Fieldset;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Новости';

    protected static ?string $navigationGroup = 'Новости';

    protected static ?string $pluralLabel = 'Новости';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->label('Категория')
                    ->options(NewsCategory::get()->pluck('title','id')->toArray())
                    ->required()
                    ->columnSpan('full'),
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->columnSpan('full'),
                FileUpload::make('img_path')
                    ->label('Изображение')
                    ->directory(function () {
                        return "/news";
                    })
                    ->columnSpan('full'),
                Textarea::make('text')
                    ->label('Текст')
                    ->rows(10)
                    ->cols(20)
                    ->columnSpan('full'),
                Fieldset::make('SEO')
                ->relationship('seoable')
                ->schema([
                    TextInput::make('meta_title')
                        ->label('Мета-заголовок')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan('full'),

                    Textarea::make('meta_description')
                        ->label('Мета-описание')
                        ->required()
                        ->maxLength(1000)
                        ->columnSpan('full'),

                    TextInput::make('meta_keywords')
                        ->label('Мета ключевые слова')
                        ->helperText('пример - новости, события, обновления, мировые новости')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan('full'),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Заголовок'),
                TextColumn::make('category.title')
                    ->searchable()
                    ->sortable()
                    ->label('Категория'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
