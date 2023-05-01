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
}