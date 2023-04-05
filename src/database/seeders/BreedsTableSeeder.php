<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reaction;

class BreedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reaction::create([
            'id' => 1,
            'name' => '',
            'height' => '',
            'weight' => '',
            'personality' => '',
            'country' => '',
            'size' => '',
            'group' => ''
        ]);
    }
}