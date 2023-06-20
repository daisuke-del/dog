<?php

namespace App\Http\Controllers;

use App\Services\ChoiceService;
use Exception;

class ChoiceController extends Controller
{

    protected $choiceService;

    public function __construct(ChoiceService $choiceService)
    {
        $this->choiceService = $choiceService;
    }

    /**
     * 顔写真ではないボタンを押下時の処理
     *
     * @param string $userId
     * @return void
     * @throws Exception
     */
    public function clickNotFace(string $userId): void
    {
        $this->choiceService->clickNotDogImageButton($userId);
        $this->choiceService->checkYellowCards($userId);
    }
}
