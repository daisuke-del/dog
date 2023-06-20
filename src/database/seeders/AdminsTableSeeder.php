<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'user_id' => '1e750a19-1e39-796d-5597-338aec724187',
            'email' => 'a@a',
            'password' => Hash::make('testtest'),
            'name' => 'aaa',
            'dog_image' => 'no-user-image-icon.png'
        ]);
    }
}
