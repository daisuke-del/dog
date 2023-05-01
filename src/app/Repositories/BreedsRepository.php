<?php

namespace App\Repositories;

use App\Exceptions\DOGException;
use Carbon\Carbon;
use App\Models\Breed;
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
}