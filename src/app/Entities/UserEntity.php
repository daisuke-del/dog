<?php

namespace App\Entities;

use App\ValueObjects\User\UserId;
use App\ValueObjects\User\Name;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\Password;
use App\ValueObjects\User\Sex;
use App\ValueObjects\User\Weight;
use App\ValueObjects\User\Birthday;
use App\ValueObjects\User\DogPoint;
use App\ValueObjects\User\DogImage;
use App\ValueObjects\User\DogImage2;
use App\ValueObjects\User\DogImage3;
use App\ValueObjects\User\Breed;
use App\ValueObjects\User\Location;
use App\ValueObjects\User\InstagramId;
use App\ValueObjects\User\TwitterId;
use App\ValueObjects\User\TiktokId;
use App\ValueObjects\User\BlogId;
use App\ValueObjects\User\UpdateDogAt;
use App\ValueObjects\User\CreateDate;
use App\ValueObjects\User\YellowCard;
use App\ValueObjects\User\DogImageVoidFlg;
use App\ValueObjects\User\OrderNumber;


class UserEntity
{
    private $userId;
    private $name;
    private $email;
    private $password;
    private $sex;
    private $weight;
    private $birthday;
    private $dogPoint;
    private $dogImage;
    private $dogImage2;
    private $dogImage3;
    private $breed;
    private $location;
    private $instagramId;
    private $twitterId;
    private $tiktokId;
    private $blogId;
    private $yellowCard;
    private $updateDogAt;
    private $createDate;
    private $dogImageVoidFlg;
    private $orderNumber;

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
     * @param Birthday $birthday
     * @param DogPoint $dogPoint
     * @param DogImage $dogImage
     * @param DogImage2 $dogImage2
     * @param DogImage3 $dogImage3
     * @param Breed $breed
     * @param Location $location
     * @param InstagramId $instagramId
     * @param TwitterId $twitterId
     * @param TiktokId $tiktokId
     * @param BlogId $blogId
     * @param YellowCard $yellowCard
     * @param UpdateDogAt $updateDogAt
     * @param createDate $createDate
     * @param DogImageVoidFlg $dogImageVoidFlg
     * @param OrderNumber $orderNumber
     * @return UserEntity
     */
    public static function getUserEntityInstance(
        UserId $userId,
        Name $name,
        Email $email,
        Password $password,
        Sex $sex,
        Weight $weight,
        Birthday $birthday,
        DogPoint $dogPoint,
        ?DogImage $dogImage,
        ?DogImage2 $dogImage2,
        ?DogImage3 $dogImage3,
        ?InstagramId $instagramId,
        ?TwitterId $twitterId,
        ?TiktokId $tiktokId,
        ?BlogId $blogId,
        YellowCard $yellowCard,
        ?UpdateDogAt $updateDogAt,
        createDate $createDate,
        DogImageVoidFlg $dogImageVoidFlg,
        ?OrderNumber $orderNumber
    ) {
        $user = new self();
        $user->userId = $userId;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->sex = $sex;
        $user->weight = $weight;
        $user->birthday = $birthday;
        $user->dogPoint = $dogPoint;
        $user->dogImage = $dogImage;
        $user->dogImage2 = $dogImage2;
        $user->dogImage3 = $dogImage3;
        $user->instagramId = $instagramId;
        $user->twitterId = $twitterId;
        $user->tiktokId = $tiktokId;
        $user->blogId = $blogId;
        $user->yellowCard = $yellowCard;
        $user->updateDogAt = $updateDogAt;
        $user->createDate = $createDate;
        $user->dogImageVoidFlg = $dogImageVoidFlg;
        $user->orderNumber = $orderNumber;
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
     * @return string
     */
    public function getWeight(): int
    {
        return $this->weight->get();
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
     * dog_imageを取得する
     *
     * @return ?string
     */
    public function getDogImage(): ?string
    {
        return $this->dogImage->get();
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
     * dog_pointを取得する
     *
     * @return int
     */
    public function getDogPoint(): int
    {
        return $this->dogPoint->get();
    }

    /**
     * breedを取得する
     *
     * @return string
     */
    public function getBreed(): string
    {
        return $this->breed->get();
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

    /**
     * order_numberを取得する
     *
     * @return ?int
     */
    public function getOrderNumber(): ?int
    {
        return $this->orderNumber->get();
    }
}
