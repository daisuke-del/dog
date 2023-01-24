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
            'to_user_ud' => '',
            'from_user_id' => '',
        ]);

        Reaction::create([
            'to_user_ud' => '',
            'from_user_id' => '',
        ]);

        Reaction::create([
            'to_user_ud' => '',
            'from_user_id' => '',
        ]);

        Reaction::create([
            'to_user_ud' => '',
            'from_user_id' => '',
        ]);

        Reaction::create([
            'to_user_ud' => '',
            'from_user_id' => '',
        ]);

        Reaction::create([
            'to_user_ud' => '',
            'from_user_id' => '',
        ]);

        Reaction::create([
            'to_user_ud' => '',
            'from_user_id' => '',
        ]);
    }
}
