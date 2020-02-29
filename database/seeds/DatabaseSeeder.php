<?php

use App\Models\MediaLibrary;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        Role::query()->firstOrCreate(['name' => Role::ROLE_EDITOR]);
        $role_admin = Role::firstOrCreate(['name' => Role::ROLE_ADMIN]);

        // MediaLibrary
        MediaLibrary::query()->firstOrCreate([]);

        // Users
        /** @var User $user */
        $user = User::query()->firstOrCreate(
            ['email' => 'hopeseekr@gmail.com'],
            [
                'username' => 'hopeseekr',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now()
            ]
        );

        $user->roles()->sync([$role_admin->id]);
    }
}
