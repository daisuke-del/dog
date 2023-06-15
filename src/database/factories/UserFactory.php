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
        $now = new Carbon();
        $num = self::$sequence++;
        if ($num % 2 === 0) {
            $sex = 'female';
        } else {
            $sex = 'male';
        }
        return [
            'name' => $this->faker->name('female'),
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'dog_image' => $num . '.jpeg',
            'sex' => $sex,
            'weight' => $this->faker->numberBetween(1, 20),
            'birthday' => $this->faker->dateTimeBetween('-20 years', '-1 years')->format('Y-m-d'),
            'dog_point' => $num,
            // TODO SNSアカウント入力
            'twitter_id' => '',
            'instagram_id' => '',
            'tiktok_id' => '',
            'blog_id'=>'',
            'yellow_card' => 0,
            'dog_image_void_flg' => 0,
            'update_dog_at' => $now,
            'create_date' => $now,
            'remember_token' => null
        ];
    }
}