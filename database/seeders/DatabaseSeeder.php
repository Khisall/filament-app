<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\PatrolCheckSeeder;
use Database\Seeders\SpinklerPumpSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@philips.com',
            'is_admin' => true
        ]);

        $this->call(LocationSeeder::class);
        $this->call(NoMapSeeder::class);
        $this->call(NewCompressorSeeder::class);
        $this->call(NewSpinklerPumpSeeder::class);
        $this->call(NewEmergencyLightSeeder::class);
        $this->call(PatrolCheckSeeder::class);
    }
}
