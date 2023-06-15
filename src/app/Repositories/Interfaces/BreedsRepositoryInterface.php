<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface BreedsRepositoryInterface
{
    /**
     * 犬種を取得する
     *
     * @return Collection
     */
    public function getBreeds(): Collection;

    /**
     * ランダムに犬種を取得する
     *
     * @return Collection
     */
    public function getBreedsRandom(): Collection;

    /**
     * 特定の犬種を取得する
     *
     * @param string $beedImagePath
     * @return Collection
     */
    public function getBreedDetail(string $breedImagePath): Collection;

    /**
     * 特定のサイズで犬種をソート
     *
     * @param string $size
     * @return Collection
     */
    public function getBreedsSize(string $size): Collection;

    /**
     * 特定のグループで犬種をソート
     *
     * @param string $group
     * @return Collection
     */
    public function getBreedsGroup(string $group): Collection;

    /**
     * 特定の国名で犬種をソート
     *
     * @param string $country
     * @return Collection
     */
    public function getBreedsCountry(string $country): Collection;

    /**
     * 特定のサイズとグループで犬種をソート
     *
     * @param string $size
     * @param string $group
     * @return Collection
     */
    public function getBreedsSizeAndGroup(string $size, string $group): Collection;

    /**
     * 特定のグループと国名で犬種をソート
     *
     * @param string $size
     * @param string $group
     * @return Collection
     */
    public function getBreedsGroupAndCountry(string $group, string $country): Collection;

    /**
     * 特定のサイズと国名で犬種をソート
     *
     * @param string $size
     * @param string $country
     * @return Collection
     */
    public function getBreedsSizeAndCountry(string $size, string $country): Collection;
}