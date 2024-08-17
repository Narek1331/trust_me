<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\{
    User,
    Role,
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
    FileUpload
};
use Filament\Tables\Columns\{
    TextColumn,
};
use Filament\Tables\Filters\{
    SelectFilter,
    Filter
};

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Пользователи';

    protected static ?string $navigationGroup = 'Пользовательские настройки';

    protected static ?string $pluralLabel = 'Пользователи';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('role_id')
                    ->label('Роль')
                    ->required()
                    ->options(Role::get()->pluck('name','id')->toArray())
                    ->columnSpan('full'),
                TextInput::make('name')
                    ->label('Имя')
                    ->required()
                    ->columnSpan('full'),
                TextInput::make('email')
                    ->unique(User::class, 'email', fn ($record) => $record)
                    ->label('Электронная почта')
                    ->required()
                    ->columnSpan('full'),
                TextInput::make('password')
                    ->label('Пароль')
                    ->required()
                    ->password()
                    ->revealable()
                    ->hidden(function($record){
                        if($record && $record->id == auth()->user()->id)
                        {
                            return false;
                        }
                        else if($record){
                            return true;
                        }
                        return false;
                    })
                    ->columnSpan('full'),
                FileUpload::make('avatar')
                    ->label('Аватар')
                    ->directory(function () {
                        return "/avatar";
                    })
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
                    ->label('Имя')
                    ->formatStateUsing(function ($record) {
                        $name = $record->name;

                        if($record->id == auth()->user()->id)
                        {
                            $name .= ' (Это я)';
                        }

                        return $name;
                    }),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Электронная почта'),
                TextColumn::make('role.name')
                    ->sortable()
                    ->label('Роль'),
                TextColumn::make('created_at')
                    ->sortable()
                    ->label('Регистрирован'),
            ])
            ->filters([
                Filter::make('only_me')
                ->label('Показывать только меня')
                ->toggle()
                ->query(function (Builder $query, array $data): Builder {
                    if(isset($data['isActive']) && $data['isActive'] == true){
                        $query = $query->where('id',auth()->user()->id);
                    }
                    return $query;
                }),
                SelectFilter::make('role')
                ->label('Роль')
                ->relationship('role', 'name')
                ->options(Role::get()->pluck('name','id'))
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
