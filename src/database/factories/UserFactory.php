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
        $height = $this->faker->numberBetween(135, 180);
        $weight = $this->faker->numberBetween(30, 80);
        $age = $this->faker->numberBetween(18, 40);
        $salary = $this->faker->numberBetween(0, 1000);
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

    /**
     * 男性のデータを生成
     *
     * @return Factory
     */
    public function male()
    {
        return $this->state(function () {
            $height = $this->faker->numberBetween(155, 190);
            $weight = $this->faker->numberBetween(50, 100);
            $age = $this->faker->numberBetween(18, 50);
            $salary = $this->faker->numberBetween(0, 1500);
            $num = self::$sequenceMale++;
            return [
                'name' => $this->faker->name('male'),
                'email' => $this->faker->safeEmail,
                'face_image' => 'm' . $num . '.jpeg',
                'gender' => 'male',
                'height' => $height,
                'weight' => $weight,
                'age' => $age,
                'salary' => $salary,
                'face_point' => $num,
                'height2' => ($height - 150) * 2,
                'weight2' => abs($weight / ($height*$height/10000) - 20) * 3,
                'age2' => abs($age - 27),
                'salary2' => $salary / 10 - 30,
            ];
        });
    }

}
