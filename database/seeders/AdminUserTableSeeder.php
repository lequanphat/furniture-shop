<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'), // default password for new employee is 123123
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'gender' => 1,
            'birth_date' => Carbon::parse('1990-01-01')->toDateString(),
            'avatar' => config('app.url') . 'storage/defaults/default_avatar.jpg',
            'is_staff' => 1,
            'is_verified' => 1,
        ]);
        $user->assignRole('Administrators');
    }
}
