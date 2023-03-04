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
            'to_user_id' => '98812476-f2bd-45bf-aae7-52e0ee96495a',
            'from_user_id' => '98815b81-a7fe-45d6-a20d-a6c4b723da53',
        ]);

        Reaction::create([
            'to_user_id' => '98812476-f2bd-45bf-aae7-52e0ee96495a',
            'from_user_id' => '98828780-f8c6-4666-8115-9654192104e1',
        ]);

        Reaction::create([
            'to_user_id' => '98812476-f2bd-45bf-aae7-52e0ee96495a',
            'from_user_id' => '988286ef-232c-4dd0-95e4-acee0318edcf',
        ]);

        Reaction::create([
            'to_user_id' => '98828648-12bc-4ec6-b6df-5916979f23d1',
            'from_user_id' => '988286ef-232c-4dd0-95e4-acee0318edcf',
        ]);

        Reaction::create([
            'to_user_id' => '98815b81-a7fe-45d6-a20d-a6c4b723da53',
            'from_user_id' => '98812476-f2bd-45bf-aae7-52e0ee96495a',
        ]);

        Reaction::create([
            'to_user_id' => '98815b81-a7fe-45d6-a20d-a6c4b723da53',
            'from_user_id' => '98828648-12bc-4ec6-b6df-5916979f23d1',
        ]);

        Reaction::create([
            'to_user_id' => '98828780-f8c6-4666-8115-9654192104e1',
            'from_user_id' => '98812476-f2bd-45bf-aae7-52e0ee96495a',
        ]);

        Reaction::create([
            'to_user_id' => '988286ef-232c-4dd0-95e4-acee0318edcf',
            'from_user_id' => '98828692-fd11-4b3c-95ff-8fd7bf668cce',
        ]);
    }
}
