<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Filament\Resources\FeedbackResource\RelationManagers;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\{
    TextColumn,
    ImageColumn
};
class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationLabel = 'Обратная связь';

    protected static ?string $navigationGroup = 'Основной';

    protected static ?string $pluralLabel = 'Обратная связь';
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->label('Имя')
                ->columnSpan('full')
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->required()
                ->email()
                ->label('Электронная почта')
                ->columnSpan('full')
                ->maxLength(255),

            Forms\Components\TextInput::make('title')
                ->required()
                ->label('Заголовок')
                ->columnSpan('full')
                ->maxLength(255),

            Forms\Components\Textarea::make('text')
                ->required()
                ->label('Текст')
                ->columnSpan('full')
                ->maxLength(2000),

            Forms\Components\DateTimePicker::make('created_at')
                ->disabled()
                ->columnSpan('full')
                ->label('Дата создания'),

            Forms\Components\DateTimePicker::make('updated_at')
                ->disabled()
                ->columnSpan('full')
                ->label('Дата обновления'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Имя'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Электронная почта'),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Заголовок'),
                TextColumn::make('text')
                    ->searchable()
                    ->sortable()
                    ->label('Текст'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->modalHeading('Удалить')
                ]),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListFeedback::route('/'),
            'view' => Pages\ViewUser::route('/{record}'),
            // 'create' => Pages\CreateFeedback::route('/create'),
            // 'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }

}
