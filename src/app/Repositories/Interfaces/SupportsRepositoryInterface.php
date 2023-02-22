<?php

namespace App\Repositories\Interfaces;

interface SupportsRepositoryInterface
{
    /**
     * @return object|false
     */
    public function getSupports(): ?object;

    /**
     * @param string $name
     * @param string $email
     * @param string $item
     * @param string $content
     * @return bool
     */
    public function insertSupports(string $name, string $email, string $item, string $content) :bool;

    /**
     * @param int $id
     */
    public function updateResolveFlg(int $id);
}