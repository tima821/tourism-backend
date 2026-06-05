<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
     {
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'username'  => 'admin',
                'password'  => Hash::make('admin123456'),
                'phone'     => '0000000000',
                'user_type' => 'admin',
                'status'    => 'active',
            ]
        );
    }
        
    
}
