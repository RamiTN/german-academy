<?php

namespace Database\Seeders;

use App\Enums\UserRole;
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
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@germanacademy.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'status' => 'active',
            ]
        );

        // Teacher
        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@germanacademy.com'],
            [
                'name' => 'Demo Teacher',
                'password' => Hash::make('password'),
                'role' => UserRole::Teacher,
                'status' => 'active',
            ]
        );

        if (!$teacherUser->teacher) {
            $teacherUser->teacher()->create([
                'bio' => 'Experienced German teacher.',
                'experience' => '10 years teaching online.',
            ]);
        }

        // Student
        $studentUser = User::firstOrCreate(
            ['email' => 'student@germanacademy.com'],
            [
                'name' => 'Demo Student',
                'password' => Hash::make('password'),
                'role' => UserRole::Student,
                'status' => 'active',
            ]
        );

        if (!$studentUser->student) {
            $studentUser->student()->create([
                'german_level' => 'A1',
            ]);
        }
    }
}
