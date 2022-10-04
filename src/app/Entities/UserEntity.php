<?php

namespace App\Entities;

use App\ValueObjects\User\Age;
use App\ValueObjects\User\AuthCode;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\FacebookId;
use App\ValueObjects\User\FaceImage;
use App\ValueObjects\User\FacePoint;
use App\ValueObjects\User\Gender;
use App\ValueObjects\User\Height;
use App\ValueObjects\User\InstagramId;
use App\ValueObjects\User\Password;
use App\ValueObjects\User\Salary;
use App\ValueObjects\User\TwitterId;
use App\ValueObjects\User\UpdateFaceAt;
use App\ValueObjects\User\createDate;
use App\ValueObjects\User\UserId;
use App\ValueObjects\User\Weight;
use App\ValueObjects\User\YellowCard;
use App\ValueObjects\User\Name;
use App\ValueObjects\User\FaceImageVoidFlg;


class UserEntity
{

    // users
    private $age;
    private $authCode;
    private $email;
    private $password;
    private $facebookId;
    private $facePoint;
    private $faceImage;
    private $gender;
    private $height;
    private $instagramId;
    private $salary;
    private $twitterId;
    private $userId;
    private $weight;
    private $yellowCard;
    private $updateFaceAt;
    private $createDate;
    private $name;
    private $faceImageVoidFlg;

    private function __construct()
    {
    }

    /**
     * UserEntityインスタンスを生成する
     *
     * @param UserId $userId
     * @param Age $age
     * @param AuthCode $authCode
     * @param Email $email
     * @param Password $password
     * @param FacebookId $facebookId
     * @param FacePoint $facePoint
     * @param FaceImage $faceImage
     * @param Gender $gender
     * @param Height $height
     * @param InstagramId $instagramId
     * @param Salary $salary
     * @param TwitterId $twitterId
     * @param Weight $weight
     * @param YellowCard $yellowCard
     * @param UpdateFaceAt $updateFaceAt
     * @param createDate $createDate
     * @param Name $name
     * @param FaceImageVoidFlg $faceImageVoidFlg
     * @return UserEntity
     */
    public static function getUserEntityInstance(
     Age $age,
     AuthCode $authCode,
     Email $email,
     Password $password,
     UserId $userId,
     FacebookId $facebookId,
     InstagramId $instagramId,
     TwitterId $twitterId,
     FacePoint $facePoint,
     FaceImage $faceImage,
     Gender $gender,
     Height $height,
     Salary $salary,
     Weight $weight,
     YellowCard $yellowCard,
     UpdateFaceAt $updateFaceAt,
     createDate $createDate,
     Name $name,
     FaceImageVoidFlg $faceImageVoidFlg
    ) {
        $user = new self();
        $user->age = $age;
        $user->authCode = $authCode;
        $user->email = $email;
        $user->password = $password;
        $user->userId = $userId;
        $user->facebookId = $facebookId;
        $user->instagramId = $instagramId;
        $user->twitterId = $twitterId;
        $user->facePoint = $facePoint;
        $user->faceImage = $faceImage;
        $user->gender = $gender;
        $user->height = $height;
        $user->salary = $salary;
        $user->weight = $weight;
        $user->yellowCard = $yellowCard;
        $user->updateFaceAt = $updateFaceAt;
        $user->createDate = $createDate;
        $user->name = $name;
        $user->faceImageVoidFlg = $faceImageVoidFlg;
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
     * ageを取得する
     *
     * @return int
     */
    public function getAge(): int
    {
        return $this->age->get();
    }

    /**
     * auth_codeを取得する
     *
     * @return string
     */
    public function getAuthCode(): string
    {
        return $this->authCode->get();
    }

    /**
     * create_dateを取得する
     *
     * @return string
     */
    public function getcreateDate(): string
    {
        return $this->createDate->get();
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
     * facebook_idを取得する
     *
     * @return string
     */
    public function getFacebookId(): string
    {
        return $this->facebookId->get();
    }

    /**
     * face_imageを取得する
     *
     * @return string
     */
    public function getFaceImage(): string
    {
        return $this->faceImage->get();
    }

    /**
     * face_pointを取得する
     *
     * @return int
     */
    public function getFacePoint(): int
    {
        return $this->facePoint->get();
    }

    /**
     * genderを取得する
     *
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender->get();
    }

    /**
     * heightを取得する
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height->get();
    }

    /**
     * instagram_idを取得する
     *
     * @return string
     */
    public function getInstagramId(): string
    {
        return $this->instagramId->get();
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
     * salaryを取得する
     *
     * @return int
     */
    public function getSalary(): int
    {
        return $this->salary->get();
    }

    /**
     * twitter_idを取得する
     *
     * @return string
     */
    public function getTwitterId(): string
    {
        return $this->twitterId->get();
    }

    /**
     * update_face_atを取得する
     *
     * @return string
     */
    public function getUpdateFaceAt(): string
    {
        return $this->updateFaceAt->get();
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
     * yellow_cardを取得する
     *
     * @return int
     */
    public function getYellowCard(): int
    {
        return $this->yellowCard->get();
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
     * face_image_void_flgを取得する
     *
     * @return int
     */
    public function getFaceImageVoidFlg(): int
    {
        return $this->faceImageVoidFlg->get();
    }

}
