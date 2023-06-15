<?php

namespace App\Entities;

use App\ValueObjects\User\UserId;
use App\ValueObjects\User\Name;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\Password;
use App\ValueObjects\User\Sex;
use App\ValueObjects\User\Weight;
use App\ValueObjects\User\DogPoint;
use App\ValueObjects\User\DogImage1;
use App\ValueObjects\User\DogImage2;
use App\ValueObjects\User\DogImage3;
use App\ValueObjects\User\Breed1;
use App\ValueObjects\User\Breed2;
use App\ValueObjects\User\InstagramId;
use App\ValueObjects\User\TwitterId;
use App\ValueObjects\User\TiktokId;
use App\ValueObjects\User\BlogId;
use App\ValueObjects\User\Birthday;
use App\ValueObjects\User\Location;
use App\ValueObjects\User\Comment;
use App\ValueObjects\User\UpdateDogAt;
use App\ValueObjects\User\CreateDate;
use App\ValueObjects\User\YellowCard;
use App\ValueObjects\User\DogImageVoidFlg;


class UserEntity
{
    private $userId;
    private $name;
    private $email;
    private $password;
    private $sex;
    private $weight;
    private $dogPoint;
    private $dogImage1;
    private $dogImage2;
    private $dogImage3;
    private $breed1;
    private $breed2;
    private $instagramId;
    private $twitterId;
    private $tiktokId;
    private $blogId;
    private $birthday;
    private $location;
    private $comment;
    private $yellowCard;
    private $updateDogAt;
    private $createDate;
    private $dogImageVoidFlg;

    private function __construct()
    {
    }

    /**
     * UserEntityインスタンスを生成する
     *
     * @param UserId $userId
     * @param Name $name
     * @param Email $email
     * @param Password $password
     * @param Sex $sex
     * @param Weight $weight
     * @param DogPoint $dogPoint
     * @param DogImage1 $dogImage1
     * @param DogImage2 $dogImage2
     * @param DogImage3 $dogImage3
     * @param Breed1 $breed1
     * @param Breed2 $breed2
     * @param InstagramId $instagramId
     * @param TwitterId $twitterId
     * @param TiktokId $tiktokId
     * @param BlogId $blogId
     * @param Birthday $birthday
     * @param Location $location
     * @param Comment $comment
     * @param YellowCard $yellowCard
     * @param UpdateDogAt $updateDogAt
     * @param CreateDate $createDate
     * @param DogImageVoidFlg $dogImageVoidFlg
     * @return UserEntity
     */
    public static function getUserEntityInstance(
        UserId $userId,
        Name $name,
        Email $email,
        Password $password,
        Sex $sex,
        Weight $weight,
        DogPoint $dogPoint,
        ?DogImage1 $dogImage1,
        ?DogImage2 $dogImage2,
        ?DogImage3 $dogImage3,
        Breed1 $breed1,
        ?Breed2 $breed2,
        ?InstagramId $instagramId,
        ?TwitterId $twitterId,
        ?TiktokId $tiktokId,
        ?BlogId $blogId,
        Birthday $birthday,
        ?Location $location,
        ?Comment $comment,
        YellowCard $yellowCard,
        ?UpdateDogAt $updateDogAt,
        createDate $createDate,
        DogImageVoidFlg $dogImageVoidFlg
    ) {
        $user = new self();
        $user->userId = $userId;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->sex = $sex;
        $user->weight = $weight;
        $user->dogPoint = $dogPoint;
        $user->dogImage1 = $dogImage1;
        $user->dogImage2 = $dogImage2;
        $user->dogImage3 = $dogImage3;
        $user->breed1 = $breed1;
        $user->breed2 = $breed2;
        $user->instagramId = $instagramId;
        $user->twitterId = $twitterId;
        $user->tiktokId = $tiktokId;
        $user->blogId = $blogId;
        $user->birthday = $birthday;
        $user->location = $location;
        $user->comment = $comment;
        $user->yellowCard = $yellowCard;
        $user->updateDogAt = $updateDogAt;
        $user->createDate = $createDate;
        $user->dogImageVoidFlg = $dogImageVoidFlg;
        return $user;
    }

    /**
     * user_idを取得する
     *
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId->get();
    }

    /**
     * emailを取得する
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email->get();
    }

    /**
     * passwordを取得する
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password->get();
    }

    /**
     * nameを取得する
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name->get();
    }

    /**
     * sexを取得する
     *
     * @return string
     */
    public function getSex(): string
    {
        return $this->sex->get();
    }

    /**
     * weightを取得する
     *
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight->get();
    }

    /**
     * dog_pointを取得する
     *
     * @return int
     */
    public function getDogPoint(): int
    {
        return $this->dogPoint->get();
    }

    /**
     * dog_imageを取得する
     *
     * @return ?string
     */
    public function getDogImage1(): ?string
    {
        return $this->dogImage1->get();
    }

    /**
     * dog_image2を取得する
     *
     * @return ?string
     */
    public function getDogImage2(): ?string
    {
        return $this->dogImage2->get();
    }

    /**
     * dog_image3を取得する
     *
     * @return ?string
     */
    public function getDogImage3(): ?string
    {
        return $this->dogImage3->get();
    }

    /**
     * breed1を取得する
     *
     * @return string
     */
    public function getBreed1(): string
    {
        return $this->breed1->get();
    }

    /**
     * breed2を取得する
     *
     * @return string
     */
    public function getBreed2(): ?string
    {
        return $this->breed2->get();
    }

    /**
     * instagram_idを取得する
     *
     * @return ?string
     */
    public function getInstagramId(): ?string
    {
        return $this->instagramId->get();
    }

    /**
     * twitter_idを取得する
     *
     * @return ?string
     */
    public function getTwitterId(): ?string
    {
        return $this->twitterId->get();
    }

    /**
     * twitter_idを取得する
     *
     * @return ?string
     */
    public function getTiktokId(): ?string
    {
        return $this->tiktokId->get();
    }

    /**
     * blog_idを取得する
     *
     * @return ?string
     */
    public function getBlogId(): ?string
    {
        return $this->blogId->get();
    }

    /**
     * birthdayを取得する
     *
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday->get();
    }

    /**
     * locationを取得する
     *
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location->get();
    }

    /**
     * commentを取得する
     *
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment->get();
    }

    /**
     * update_dog_atを取得する
     *
     * @return ?string
     */
    public function getUpdateDogAt(): ?string
    {
        return $this->updateDogAt->get();
    }

    /**
     * create_dateを取得する
     *
     * @return string
     */
    public function getCreateDate(): string
    {
        return $this->createDate->get();
    }

    /**
     * yellow_cardを取得する
     *
     * @return int
     */
    public function getYellowCard(): int
    {
        return $this->yellowCard->get();
    }

    /**
     * dog_image_void_flgを取得する
     *
     * @return int
     */
    public function getDogImageVoidFlg(): int
    {
        return $this->dogImageVoidFlg->get();
    }

}
