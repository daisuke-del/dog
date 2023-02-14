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
            'email' => 'a@a',
            'password' => Hash::make('testtest'),
            'name' => 'aaa',
            'face_image' => 'no-user-image-icon.jpeg',
            'gender' => 'male',
            'height' => 180,
            'weight' => 70,
            'age' => 40,
            'salary' => 1000,
        ]);
    }
}
