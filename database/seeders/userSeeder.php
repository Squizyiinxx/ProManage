<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;


class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@promanage.test',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@promanage.test',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);
        $manager->assignRole('manager');
    }
}
