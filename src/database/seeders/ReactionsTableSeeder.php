<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reaction;

class ReactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //migrationしたusersの情報を入力。
        Reaction::create([
            'to_user_id' => '984d47ef-91ee-4a25-ba6d-32d6b2e0b787',
            'from_user_id' => '98511ec5-87c7-4e9f-b576-3d79ff90d8a9',
        ]);

        Reaction::create([
            'to_user_id' => '984d47ef-91ee-4a25-ba6d-32d6b2e0b787',
            'from_user_id' => '985120b7-766a-4a0c-842e-89af55389450',
        ]);

        Reaction::create([
            'to_user_id' => '984d47ef-91ee-4a25-ba6d-32d6b2e0b787',
            'from_user_id' => '98512162-4540-4e2a-b12f-58658b421d03',
        ]);

        Reaction::create([
            'to_user_id' => '98511ec5-87c7-4e9f-b576-3d79ff90d8a9',
            'from_user_id' => '984d47ef-91ee-4a25-ba6d-32d6b2e0b787',
        ]);

        Reaction::create([
            'to_user_id' => '985120b7-766a-4a0c-842e-89af55389450',
            'from_user_id' => '984d47ef-91ee-4a25-ba6d-32d6b2e0b787',
        ]);

        Reaction::create([
            'to_user_id' => '98512162-4540-4e2a-b12f-58658b421d03',
            'from_user_id' => '984d47ef-91ee-4a25-ba6d-32d6b2e0b787',
        ]);

        Reaction::create([
            'to_user_id' => '98512162-4540-4e2a-b12f-58658b421d03',
            'from_user_id' => '984f354c-e047-4140-8d11-0e4d2c0de4d7',
        ]);
    }
}
