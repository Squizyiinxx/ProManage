<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Projects;
use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;


class projectSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = Client::first();
        $manager = User::role('manager')->first();
        Projects::create([
            'name' => 'Project Alpha',
            'description' => 'This is a description for Project Alpha.',
            'client_id' => $client->id,
            'manager_id' => $manager->id,
            'started_at' =>  Carbon::now(),
            'is_active' => true,
        ]);
    }
}
