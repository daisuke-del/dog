<?php

namespace App\ValueObjects\User;

use App\Exceptions\MARIGOLDException;
use Illuminate\Support\Facades\Validator;

class CreateDate
{
    private $createDate;

    public function __construct(string $createDate)
    {
        if ($this->isCreateDate($createDate) === false) {
            throw new MARIGOLDException('validation.create_date', 422);
        }
        $this->createDate = $createDate;
    }

    /**
     * create_dateを取得する
     *
     * @return string
     */
    public function get(): string
    {
        return $this->createDate;
    }

    /**
     * create_dateのValidationチェック
     *
     * @param string $createDate
     * @return bool
     */
    private function isCreateDate(string $createDate): bool
    {
        return Validator::make([$createDate], ['required|date_format:Y-m-d H:i:s'])->passes();
    }
}
