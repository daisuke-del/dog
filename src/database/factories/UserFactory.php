<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFactory extends Factory
{
    use HasFactory;

    protected $model = User::class;

    private static $sequence = 0;
    private static $sequenceMale = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dt = new Carbon();
        $date = $dt->subDay(60);
        $num = self::$sequence++;
        return [
            'name' => $this->faker->name('female'),
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'face_image' => $num . 'jpeg',
            'gender' => 'female',
            'height' => $this->faker->numberBetween(135, 180),
            'weight' => $this->faker->numberBetween(30, 80),
            'age' => $this->faker->numberBetween(18, 40),
            'salary' => $this->faker->numberBetween(0, 1000),
            'face_point' => $num,
            'update_face_at' => $date,
            'create_date' => $date,
            'yellow_card' => 0,
            'twitter_id' => 'https://twitter.com/oo__aru_me',
            'instagram_id' => 'https://www.instagram.com/steinberg_fan/',
            'facebook_id' => 'https://www.facebook.com/y.kai1',
            'auth_code' => null,
            'email_confirm_flg' => 1,
            'face_image_void_flg' => 0,
            'order_number' => $this->faker->numberBetween(1, 10000)
        ];
    }

    /**
     * 男性のデータを生成
     *
     * @return Factory
     */
    public function male()
    {
        return $this->state(function () {
            return [
                'name' => $this->faker->name('male'),
                'gender' => 'male',
                'face_point' => function () { return self::$sequenceMale++; }
            ];
        });
    }

}
