<?php

namespace App\Services;

use App\Exceptions\DOGException;
use Carbon\Carbon;
use App\Repositories\SupportsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SupportService
{

    private $supportsRepository;

    /**
     * @var SupportRepository
     */
    public function __construct()
    {
        $this->supportsRepository = new SupportsRepository;
    }

    /**
     * @return object
     */
    public function getSupports()
    {
        return $this->supportsRepository->getSupports();
    }

    /**
     * @param Request $request
     */
    public function sendSupport($request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $item = $request->input('item');
        $content = $request->input('content');
        $result = $this->supportsRepository->insertSupports($name, $email, $item, $content);

        if (!$result) {
            throw new DOGException(config('const.ERROR.SUPPORT.SEND_FAILED'), 400);
        }

        return [];

    }

    /**
     * @param Request $request
     */
    public function resolveSupport($request)
    {
        $id = $request->input('id');
        $this->supportsRepository->updateResolveFlg($id);
    }
}