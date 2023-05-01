<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Services\BreedService;
use App\Exceptions\DOGException;
use Log;

class BreedController extends Controller
{
    protected $breedService;

    public function __construct(BreedService $breedService)
    {
        $this->breedService = $breedService;
    }

    /**
     * 犬種を全て取得
     *
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function info()
    {
        $response = $this->breedService->getBreeds();
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 特定の犬種を取得
     *
     * @param string $breed
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function detail(string $breed)
    {
        $response = $this->breedService->getBreedDetail($breed);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * ルートパスに使用する犬種を取得
     *
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function route()
    {
        $breeds = $this->breedService->getBreeds()->array();
        $response = [];
        foreach ($breeds as $breed) {
            $breedImagePath = $breed['dog_image'];
            $breedName = str_replace('.png', '', $breedImagePath);
            $response[] = $breedName;
        }
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}