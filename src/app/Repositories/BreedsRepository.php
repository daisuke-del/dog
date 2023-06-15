<?php

namespace App\Repositories;

use App\Repositories\Interfaces\breedsRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BreedsRepository implements BreedsRepositoryInterface
{
    /**
     * 犬種を取得する
     *
     * @return Collection
     */
    public function getBreeds(): Collection
    {
        return DB::table('breeds')
            ->get();
    }

    /**
     * ランダムに犬種を取得する
     *
     * @return Collection
     */
    public function getBreedsRandom(): Collection
    {
        return DB::table('breeds')
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    /**
     * 特定の犬種を取得する
     *
     * @param string $beedImagePath
     * @return Collection
     */
    public function getBreedDetail(string $breedImagePath): Collection
    {
        return DB::table('breeds')
            ->where('dog_image', $breedImagePath)
            ->get();
    }

    /**
     * 特定のサイズで犬種をソート
     *
     * @param string $size
     * @return Collection
     */
    public function getBreedsSize(string $size): Collection
    {
        return DB::table('breeds')
            ->where('size', $size)
            ->get();
    }

    /**
     * 特定のグループで犬種をソート
     *
     * @param string $group
     * @return Collection
     */
    public function getBreedsGroup(string $group): Collection
    {
        return DB::table('breeds')
            ->where('group', $group)
            ->get();
    }

    /**
     * 特定の国名で犬種をソート
     *
     * @param string $country
     * @return Collection
     */
    public function getBreedsCountry(string $country): Collection
    {
        return DB::table('breeds')
            ->where('country', $country)
            ->get();
    }

    /**
     * 特定のサイズとグループで犬種をソート
     *
     * @param string $size
     * @param string $group
     * @return Collection
     */
    public function getBreedsSizeAndGroup(string $size, string $group): Collection
    {
        return DB::table('breeds')
            ->where('size', $size)
            ->where('group', $group)
            ->get();
    }

    /**
     * 特定のグループと国名で犬種をソート
     *
     * @param string $size
     * @param string $group
     * @return Collection
     */
    public function getBreedsGroupAndCountry(string $group, string $country): Collection
    {
        return DB::table('breeds')
            ->where('group', $group)
            ->where('country', $country)
            ->get();
    }

    /**
     * 特定のサイズと国名で犬種をソート
     *
     * @param string $size
     * @param string $country
     * @return Collection|null
     */
    public function getBreedsSizeAndCountry(string $size, string $country): Collection
    {
        return DB::table('breeds')
            ->where('size', $size)
            ->where('country', $country)
            ->get();
    }

    /**
     * 特定のサイズとグループと国名で犬種をソート
     *
     * @param string $size
     * @param string $group
     * @param string $country
     * @return Collection|null
     */
    public function getBreedsSort(string $size, string $group, string $country): Collection
    {
        return DB::table('breeds')
            ->where('size', $size)
            ->where('group', $group)
            ->where('country', $country)
            ->get();
    }
}