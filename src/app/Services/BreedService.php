<?php

namespace App\Services;

use App\Repositories\BreedsRepository;
use Illuminate\Http\Request;

class BreedService
{
    private $breedsRepository;

    public function __construct()
    {
        $this->breedsRepository = new BreedsRepository;
    }

    /**
     * 犬種を全て取得
     *
     * @return Collection
     */
    public function getBreeds()
    {
        return $this->breedsRepository->getBreeds();
    }

    /**
     * トップページ用の犬種をランダム取得
     *
     * @return Collection
     */
    public function getBreedsRandom()
    {
        return $this->breedsRepository->getBreedsRandom();
    }

    /**
     * 特定の犬種を取得
     *
     * @param string $breed
     * @return array
     */
    public function getBreedDetail(string $breed)
    {
        $breedImagePath = $breed . '.png';
        return $this->breedsRepository->getBreedDetail($breedImagePath)->toArray();
    }

    /**
     * 特定のサイズで犬種をソート
     *
     * @param string $size
     * @return Collection
     */
    public function getBreedsSize(string $size)
    {
        return $this->breedsRepository->getBreedsSize($size);
    }

    /**
     * 特定のグループで犬種をソート
     *
     * @param string $group
     * @return Collection
     */
    public function getBreedsGroup(string $group)
    {
        return $this->breedsRepository->getBreedsGroup($group);
    }

    /**
     * 特定の国名で犬種をソート
     *
     * @param string $country
     * @return Collection
     */
    public function getBreedsCountry(string $country)
    {
        return $this->breedsRepository->getBreedsCountry($country);
    }

    /**
     * 特定のサイズとグループで犬種をソート
     *
     * @param string $size
     * @param string $group
     * @return Collection|null
     */
    public function getBreedsSizeAndGroup(string $size, string $group)
    {
        return $this->breedsRepository->getBreedsSizeAndGroup($size, $group);
    }

    /**
     * 特定のグループと国名で犬種をソート
     *
     * @param string $size
     * @param string $group
     * @return Collection|null
     */
    public function getBreedsGroupAndCountry(string $group, string $country)
    {
        return $this->breedsRepository->getBreedsGroupAndCountry($group, $country);
    }

    /**
     * 特定のサイズと国名で犬種をソート
     *
     * @param string $size
     * @param string $country
     * @return Collection|null
     */
    public function getBreedsSizeAndCountry(string $size, string $country)
    {
        return $this->breedsRepository->getBreedsSizeAndCountry($size, $country);
    }

    /**
     * 特定のサイズとグループと国名で犬種をソート
     *
     * @param string $size
     * @param string $group
     * @param string $country
     * @return Collection|null
     */
    public function getBreedsSort(string $size, string $group, string $country)
    {
        return $this->breedsRepository->getBreedsSort($size, $group, $country);
    }
}