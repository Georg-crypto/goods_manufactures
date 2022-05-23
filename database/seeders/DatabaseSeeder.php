<?php

namespace Database\Seeders;

use App\Models\Good;
use App\Models\GoodManufacture;
use App\Models\Manufacture;
use Database\Factories\GoodFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Good::factory(20)->create();
        Manufacture::factory(20)->create();
        GoodManufacture::factory(50)->create();

    }
}
