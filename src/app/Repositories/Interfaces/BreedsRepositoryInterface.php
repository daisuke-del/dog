<?php

namespace App\Repositories\Interfaces;

use App\Exceptions\DOGException;
use Carbon\Carbon;
use App\Models\Breed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

interface BreedsRepositoryInterface
{
    /**
     * 犬種を取得する
     *
     * @return Collection
     */
    public function getBreeds(): Collection;

    /**
     * 特定の犬種を取得する
     *
     * @param string $beedImagePath
     * @return Collection
     */
    public function getBreedDetail(string $breedImagePath): Collection;
}