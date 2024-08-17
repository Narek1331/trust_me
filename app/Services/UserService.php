<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function updateProfile(array $data, $avatar = null)
    {
        $user = Auth::user();
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

    public function updatePassword(array $data)
    {
        $user = Auth::user();

        if (!Hash::check($data['current_password'], $user->password)) {
            throw new \Exception('Current password is incorrect.');
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();
    }
}
