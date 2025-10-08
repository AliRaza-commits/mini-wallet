<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $users = [
            [
                'name' => 'Ali Raza',
                'email' => 'ali@gmail.com',
                'password' => Hash::make('asd123456'),
                'balance' => 5000,
            ],
            [
                'name' => 'Bilal',
                'email' => 'bilal@gmail.com',
                'password' => Hash::make('asd123456'),
                'balance' => 5000,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
