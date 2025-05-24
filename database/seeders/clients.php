<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class clients extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'name' => 'Agus',
            'email' => 'ms21@gmail.com',
            'phone' => '081234567890',
            'company' => 'PT Mitra Sejahtera',
            'address' => 'Jl. Raya Pemorgraman No. 123, Jakarta',
            'is_active' => true,
        ]);
    }
}
