<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;

        if(isset($data['child_check_id']))
        {
            $data['check_id'] = $data['child_check_id'];
        }

        return $data;
    }

    // protected function afterCreate(): array
    // {
    // }
}
