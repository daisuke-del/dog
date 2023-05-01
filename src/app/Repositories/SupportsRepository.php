<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\SupportsRepositoryInterface;

class SupportsRepository implements SupportsRepositoryInterface
{

    /**
     * @return object|false
     */
    public function getSupports(): ?object
    {
        return table('supports')
            ->where('resolve_flg', 0)
            ->get();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $item
     * @param string $content
     * @return bool
     */
    public function insertSupports(string $name, string $email, string $item, string $content): bool
    {
        return DB::table('supports')
            ->insert([
                ['name' => $name, 'email' => $email, 'support_item' => $item, 'support_content' => $content]
            ]);
    }

    /**
     * @param int $id
     */
    public function updateResolveFlg(int $id)
    {
        return DB::table('supports')
            ->where('id', $id)
            ->update(
                ['resolve_flg' => 1]
            );
    }
}