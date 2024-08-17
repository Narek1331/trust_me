<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\{
    Comment,
    ReviewType,
    Rating,
    Check
};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{
    CheckboxList,
    TextInput,
    Select,
    Textarea,
    Fieldset,
    MultiSelect
};
use Filament\Tables\Columns\{
    TextColumn,
};
use Filament\Tables\Filters\SelectFilter;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Комментарии';

    protected static ?string $navigationGroup = 'Основной';

    protected static ?string $pluralLabel = 'Комментарии';

    public static function form(Form $form): Form
    {

        $positiveReviewType = ReviewType::where('slug', 'positive')->firstOrFail();
        $negativeReviewType = ReviewType::where('slug', 'negative')->firstOrFail();

        return $form
            ->schema([
                Select::make('check_id')
                    ->label('Тип поиска')
                    ->options(Check::where('parent_id',null)->get()->pluck('name','id'))
                    ->required()
                    ->reactive()
                    ->columnSpan('full'),
                Select::make('child_check_id')
                    ->label('')
                    ->options(function($get){
                        $checkId = $get('check_id');
                        if($checkId && $checks = Check::where('parent_id',$checkId)->get()->pluck('name','id'))
                        {
                            if(count($checks))
                            {
                                return $checks;
                            }
                        }
                        return [];
                    })
                    ->required()
                    ->reactive()
                    ->hidden(function($get){
                        $checkId = $get('check_id');
                        if($checkId && $checks = Check::where('parent_id',$checkId)->get()->pluck('name','id'))
                        {
                            if(count($checks))
                            {
                            return false;
                            }
                        }
                        return true;
                    })
                    ->columnSpan('full'),
                TextInput::make('search')
                    ->maxLength(255)
                    ->label('Поиск')
                    ->required()
                    ->columnSpan('full'),
                Fieldset::make('Оценить сайт')
                    ->schema([
                        CheckboxList::make('positiveRates')
                            ->label('Доверяю!')
                            ->options(Rating::where('review_type_id',$positiveReviewType->id)->get()->pluck('name', 'id'))
                            ->relationship(titleAttribute: 'name')
                            ->reactive(),
                        CheckboxList::make('negativeRates')
                            ->label('Не доверяю!')
                            ->options(Rating::where('review_type_id',$positiveReviewType->id)->get()->pluck('name', 'id'))
                            ->relationship(titleAttribute: 'name')
                            ->reactive()
                    ])
                    ->columns(2)
                    ->columnSpan('full'),
                Select::make('review_type_id')
                    ->label('Отзыв')
                    ->options(ReviewType::get()->pluck('name','id'))
                    ->required()
                    ->columnSpan('full'),
                Textarea::make('text')
                    ->label('Комментарий')
                    ->rows(10)
                    ->cols(20)
                    ->columnSpan('full'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('search')
                    ->label('Поиск')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
