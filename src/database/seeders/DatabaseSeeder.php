<?php

namespace Database\Seeders;

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
        // $this->call(ReactionsTableSeeder::class);

        // \App\Models\User::factory()->count(101)->create();
        \App\Models\User::factory()->count(101)->male()->create();
    }
}
