<?php

namespace App\Entities;

use App\ValueObjects\User\UserId;
use App\ValueObjects\User\Name;
use App\ValueObjects\User\Email;
use App\ValueObjects\User\Password;
use App\ValueObjects\User\Gender;
use App\ValueObjects\User\Height;
use App\ValueObjects\User\Weight;
use App\ValueObjects\User\Age;
use App\ValueObjects\User\Salary;
use App\ValueObjects\User\FacePoint;
use App\ValueObjects\User\Height2;
use App\ValueObjects\User\Weight2;
use App\ValueObjects\User\Age2;
use App\ValueObjects\User\Salary2;
use App\ValueObjects\User\FacePoint2;
use App\ValueObjects\User\FaceImage;
use App\ValueObjects\User\FacebookId;
use App\ValueObjects\User\InstagramId;
use App\ValueObjects\User\TwitterId;
use App\ValueObjects\User\UpdateFaceAt;
use App\ValueObjects\User\createDate;
use App\ValueObjects\User\YellowCard;
use App\ValueObjects\User\FaceImageVoidFlg;
use App\ValueObjects\User\OrderNumber;


class UserEntity
{
    private $userId;
    private $name;
    private $email;
    private $password;
    private $gender;
    private $height;
    private $weight;
    private $age;
    private $salary;
    private $facePoint;
    private $height2;
    private $weight2;
    private $age2;
    private $salary2;
    private $facePoint2;
    private $faceImage;
    private $facebookId;
    private $instagramId;
    private $twitterId;
    private $yellowCard;
    private $updateFaceAt;
    private $createDate;
    private $faceImageVoidFlg;
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
     * @param Gender $gender
     * @param Height $height
     * @param Weight $weight
     * @param Age $age
     * @param Salary $salary
     * @param FacePoint $facePoint
     * @param Height2 $height2
     * @param Weight2 $weight2
     * @param Age2 $age2
     * @param Salary2 $salary2
     * @param FacePoint2 $facePoint2
     * @param FaceImage $faceImage
     * @param FacebookId $facebookId
     * @param InstagramId $instagramId
     * @param TwitterId $twitterId
     * @param YellowCard $yellowCard
     * @param UpdateFaceAt $updateFaceAt
     * @param createDate $createDate
     * @param FaceImageVoidFlg $faceImageVoidFlg
     * @param OrderNumber $orderNumber
     * @return UserEntity
     */
    public static function getUserEntityInstance(
        UserId $userId,
        Name $name,
        Email $email,
        Password $password,
        Gender $gender,
        Height $height,
        Weight $weight,
        Age $age,
        Salary $salary,
        FacePoint $facePoint,
        Height2 $height2,
        Weight2 $weight2,
        Age2 $age2,
        Salary2 $salary2,
        FacePoint2 $facePoint2,
        ?FaceImage $faceImage,
        ?FacebookId $facebookId,
        ?InstagramId $instagramId,
        ?TwitterId $twitterId,
        YellowCard $yellowCard,
        ?UpdateFaceAt $updateFaceAt,
        createDate $createDate,
        FaceImageVoidFlg $faceImageVoidFlg,
        ?OrderNumber $orderNumber
    ) {
        $user = new self();
        $user->userId = $userId;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->gender = $gender;
        $user->height = $height;
        $user->weight = $weight;
        $user->age = $age;
        $user->salary = $salary;
        $user->facePoint = $facePoint;
        $user->height2 = $height2;
        $user->weight2 = $weight2;
        $user->age2 = $age2;
        $user->salary2 = $salary2;
        $user->facePoint2 = $facePoint2;
        $user->faceImage = $faceImage;
        $user->facebookId = $facebookId;
        $user->instagramId = $instagramId;
        $user->twitterId = $twitterId;
        $user->yellowCard = $yellowCard;
        $user->updateFaceAt = $updateFaceAt;
        $user->createDate = $createDate;
        $user->faceImageVoidFlg = $faceImageVoidFlg;
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
     * ageを取得する
     *
     * @return int
     */
    public function getAge(): int
    {
        return $this->age->get();
    }

    /**
     * age2を取得する
     *
     * @return int
     */
    public function getAge2(): int
    {
        return $this->age2->get();
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
     * @return ?string
     */
    public function getFacebookId(): ?string
    {
        return $this->facebookId->get();
    }

    /**
     * face_imageを取得する
     *
     * @return ?string
     */
    public function getFaceImage(): ?string
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
     * face_point2を取得する
     *
     * @return int
     */
    public function getFacePoint2(): int
    {
        return $this->facePoint2->get();
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
     * height2を取得する
     *
     * @return int
     */
    public function getHeight2(): int
    {
        return $this->height2->get();
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
     * salary2を取得する
     *
     * @return int
     */
    public function getSalary2(): int
    {
        return $this->salary2->get();
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
     * update_face_atを取得する
     *
     * @return ?string
     */
    public function getUpdateFaceAt(): ?string
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
     * weight2を取得する
     *
     * @return int
     */
    public function getWeight2(): int
    {
        return $this->weight2->get();
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
