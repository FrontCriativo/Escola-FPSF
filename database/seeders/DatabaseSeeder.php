<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@escolafps.local')],
            [
                'name' => env('ADMIN_NAME', 'Administrador'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin@2026')),
                'phone' => null,
                'email_verified_at' => now(),
                'is_admin' => true,
                'enrollment_number' => null,
                'class_name' => null,
                'enrollment_status' => null,
                'enrollment_started_at' => null,
            ],
        );
    }
}
