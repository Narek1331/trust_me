<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfoResource\Pages;
use App\Filament\Resources\InfoResource\RelationManagers;
use App\Models\Info;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{
    FileUpload,
    TextInput,
    Select,
    Textarea,
    Fieldset,
    MultiSelect
};
use Filament\Tables\Columns\{
    TextColumn,
};
class InfoResource extends Resource
{
    protected static ?string $model = Info::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Дополнительная информация';

    protected static ?string $navigationGroup = 'Основной';

    protected static ?string $pluralLabel = 'Дополнительная информация';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('search')
                    ->maxLength(255)
                    ->label('Поиск')
                    ->columnSpan('full'),
                FileUpload::make('img_path')
                    ->label('Изображение')
                    ->directory(function () {
                        return "/info";
                    })
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
            ->columns([
                TextColumn::make('search')
                    ->sortable()
                    ->searchable()
                    ->label('Поиск'),
                TextColumn::make('description')
                    ->sortable()
                    ->searchable()
                    ->label('Описание'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Удалить')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListInfos::route('/'),
            'create' => Pages\CreateInfo::route('/create'),
            'edit' => Pages\EditInfo::route('/{record}/edit'),
        ];
    }
}
