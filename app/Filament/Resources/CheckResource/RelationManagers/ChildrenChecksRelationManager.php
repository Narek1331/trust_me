<?php

namespace App\Filament\Resources\CheckResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
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
    ImageColumn
};
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class ChildrenChecksRelationManager extends RelationManager
{
    protected static string $relationship = 'childrenChecks';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Подвыборы';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                TextInput::make('url')
                    ->label('URL-адрес')
                    ->maxLength(255)
                    ->columnSpan('full'),
                FileUpload::make('logo_path')
                    ->label('Логотип')
                    ->directory(function () {
                        return "/logo";
                    })
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('order_by')
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Название'),
                TextColumn::make('url')
                    ->searchable()
                    ->label('URL-адрес'),
                ImageColumn::make('logo_path')
                    ->label('Логотип')
                    ->size(50),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label("Добавить")
                ->modalHeading("Добавить"),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label("Редактировать")
                ->modalHeading("Редактирование изображение"),
                Tables\Actions\DeleteAction::make()
                ->label("Удалить")
                ->modalHeading("Удалить"),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->label('Удалить выбранное')
                    ->modalHeading('Удалить'),
                ]),
            ])
            ->emptyStateHeading('Не найдено')
            ->emptyStateDescription('');
    }
}
