<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFactory extends Factory
{
    use HasFactory;

    protected $model = Reaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name('female'),
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'face_image' => $num . '.jpeg',
            'gender' => 'female',
            'height' => $height,
            'weight' => $weight,
            'age' => $age,
            'salary' => $salary,
            'face_point' => $num,
            'height2' => 40,
            'weight2' => ($weight / ($height*$height/10000) - 20) * 3,
            'age2' => $age - 23,
            'salary2' => $salary / 10 - 30,
            'face_point2' => $num * 2,
            'update_face_at' => $date,
            'create_date' => $date,
            'yellow_card' => 0,
            'twitter_id' => 'https://twitter.com/oo__aru_me',
            'instagram_id' => 'https://www.instagram.com/steinberg_fan/',
            'facebook_id' => 'https://www.facebook.com/y.kai1',
            'face_image_void_flg' => 0,
            'order_number' => $this->faker->numberBetween(1, 10000),
            'remember_token' => null
        ];
    }

}
