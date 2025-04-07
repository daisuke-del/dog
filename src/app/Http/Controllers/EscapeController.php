<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Services\EscapeService;
use App\Exceptions\DOGException;
use Log;

class EscapeController extends Controller
{
    protected $escapeService;

    public function __construct(EscapeService $escapeService)
    {
        $this->escapeService = $escapeService;
    }

    /**
     * 問題振り分け
     *
     * @param Request $request
     * @throws Exception
     * @throws Throwable
     */
    public function solve(Request $request)
    {
      $id = (int)$request->input('id');
      $code = $request->input('code') ?: '';

      switch ($id) {
        case 1: $response = $this->escapeService->solve1($code); break;
        case 2: $response = $this->escapeService->solve2($code); break;
        case 3: $response = $this->escapeService->solve3($code); break;
        case 4: $response = $this->escapeService->solve4($code); break;
        case 5: $response = $this->escapeService->solve5($code); break;
        case 6: $response = $this->escapeService->solve6($code); break;
        case 10: $response = $this->escapeService->solve10($code); break;
        default:
            return response()->json(['error' => '不正な問題IDです'], 400);
      }
      return response()->json($response);
    }
  }