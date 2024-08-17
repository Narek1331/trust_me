<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Comment;
class EditComment extends EditRecord
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        if($record)
        {
            $comment = Comment::find($record);
            if($comment && $comment->check && $checkParentId =  $comment->check->parent_id)
            {
                $this->data['child_check_id'] = $this->data['check_id'];
                $this->data['check_id'] = $checkParentId;
            }
        }
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {

        if(isset($data['child_check_id']))
        {
            $data['check_id'] = $data['child_check_id'];
        }

        return $data;
    }
}
