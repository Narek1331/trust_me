<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where("slug","admin")->first();

        $users = [];

        if($adminRole)
        {
            $users[] =  [
                'name' => 'Админ',
                'email' => 'admin@gmail.com',
                'password' => '12345678',
                'email_verified_at' => now(),
                'role_id' => $adminRole->id
            ];
        }

        foreach($users as $user)
        {
            User::create($user);
        }
    }
}
