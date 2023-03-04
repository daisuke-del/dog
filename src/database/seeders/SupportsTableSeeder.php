<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Support;

class SupportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Support::create([
            'name' => 'yamada',
            'email' => 'yamada@yamada.com',
            'support_item' => '不具合',
            'support_content' => 'あいうえおかきくけこさしすせそたちツテと',
        ]);
    }
}