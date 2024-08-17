<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function updateProfile(User $user, array $data, $avatar = null)
    {
        $user->name = $data['name'];

        if ($avatar) {
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }
            $avatarPath = $avatar->store('avatars', 'public');
            $user->avatar = basename($avatarPath);
        }

        $user->save();
    }

    public function updatePassword(User $user, array $data)
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            throw new \Exception('Current password is incorrect.');
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();
    }
}
