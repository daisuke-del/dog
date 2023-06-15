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
     * トップページ用の犬種をランダムに取得
     *
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function random()
    {
        $response = $this->breedService->getBreedsRandom();
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

    // /**
    //  * サイズでソート
    //  *
    //  * @param Request $request
    //  * @return false|string
    //  * @throws Exception
    //  * @throws Throwable
    //  */
    // public function size(Request $request)
    // {
    //     $size = $request->input('value');
    //     if (empty($size)) {
    //         $breeds = $this->breedService->getBreeds();
    //     } else {
    //         $breeds = $this->breedService->getBreedsSizeSort($size)->toArray();
    //     }
    //     return json_encode($breeds, JSON_UNESCAPED_UNICODE);
    // }

    // /**
    //  * グループでソート
    //  *
    //  * @param Request $request
    //  * @return false|string
    //  * @throws Exception
    //  * @throws Throwable
    //  */
    // public function group(Request $request)
    // {
    //     $group = $request->input('value');
    //     if (empty($group)) {
    //         $breeds = $this->breedService->getBreeds();
    //     } else {
    //         $breeds = $this->breedService->getBreedsGroupSort($group)->toArray();
    //     }
    //     return json_encode($breeds, JSON_UNESCAPED_UNICODE);
    // }

    // /**
    //  * 国名でソート
    //  *
    //  * @param Request $request
    //  * @return false|string
    //  * @throws Exception
    //  * @throws Throwable
    //  */
    // public function country(Request $request)
    // {
    //     $country = $request->input('value');
    //     if (empty($country)) {
    //         $breeds = $this->breedService->getBreeds();
    //     } else {
    //         $breeds = $this->breedService->getBreedsCountrySort($country)->toArray();
    //     }
    //     return json_encode($breeds, JSON_UNESCAPED_UNICODE);
    // }

    /**
     * ソート
     *
     * @param Request $request
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function sort(Request $request)
    {
        $size = $request->input('size') ?: null;
        $group = $request->input('group') ?: null;
        $country = $request->input('country') ?: null;
        if (empty($size) && empty($group) && empty($country)) {
            $breeds = $this->breedService->getBreeds();
        } else if (empty($size) && !empty($group) && !empty($country)) {
            $breeds = $this->breedService->getBreedsGroupAndCountry($group, $country)->toArray();
        } else if (!empty($size) && empty($group) && !empty($country)) {
            $breeds = $this->breedService->getBreedsSizeAndCountry($size, $country)->toArray();
        } else if (!empty($size) && !empty($group) && empty($country)) {
            $breeds = $this->breedService->getBreedsSizeAndGroup($size, $group)->toArray();
        } else if (!empty($size) && empty($group) && empty($country)) {
            $breeds = $this->breedService->getBreedsSize($size)->toArray();
        } else if (empty($size) && !empty($group) && empty($country)) {
            $breeds = $this->breedService->getBreedsGroup($group)->toArray();
        } else if (empty($size) && empty($group) && !empty($country)) {
            $breeds = $this->breedService->getBreedsCountry($country)->toArray();
        } else {
            $breeds = $this->breedService->getBreedsSort($size, $group, $country)->toArray();
        }
        return json_encode($breeds, JSON_UNESCAPED_UNICODE);
    }
}