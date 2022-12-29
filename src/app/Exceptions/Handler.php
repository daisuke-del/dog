<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        if ($exception instanceof MATCHExeption) {
            $log = '[' . $exception->getCode() . '] ' . $exception->getMessage();
            $param = $exception->getParam();
            if (empty($param) === false) {
                $log .= ' ' . json_encode($param, JSON_UNESCAPED_UNICODE);
            }
            Log::error($log . ' exception:' . $exception);
            return;
        }
        if ($exception instanceof ValidationException) {
            $errorBag = 'something validation error';
            if (isset($exception->errorBag)) {
                $errorBag = $exception->errorBag->first();
            }
            Log::error('[' . $exception->getCode() . '] ' . 'validate ' . $errorBag . ' exception' . $exception);
            return;
        }
        if ($exception instanceof AuthenticationException) {
            Log::error('[401] ' . $exception->getMessage() . ' exception' . $exception);
            return;
        }
        if ($this->isHttpException($exception)) {
            Log::error('[' . $exception->getStatusCode() . '] ' . $exception->getMessage() . ' exception' . $exception);
            return;
        }
        $message = json_decode($exception->getMessage(), true);
        if (isset($message)) {
            Log::error('[' . $exception->getCode() . '] ' . $message['error']['reason'] . ' exception' . $exception);
            return;
        }
        Log::error('[' . $exception->getCode() . '] ' . $exception->getMessage() . ' exception' . $exception);
        return;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (env('BASE_URL') === env('BASE_URL_PAYMENT')) {
            if ($exception instanceof MATCHExeption) {
                $param = $exception->getParam();
                if (isset($param['retry_notification']) && $param['retry_notification'] === true) {
                    return $this->retryForPayment();
                }
            }
            return $this->renderForPayment();
        }
        if ($exception instanceof MATCHExeption) {
            $res = ['error' => $exception->getMessage()];
            $param = $exception->getParam();
            foreach ($param as $key => $value) {
                $res[$key] = $value;
            }
            return response(json_encode($res, JSON_UNESCAPED_UNICODE), $exception->getCode());
        }
        if ($exception instanceof ValidationException) {
            $errorBag = 'something validation error';
            if (isset($exception->errorBag)) {
                $errorBag = $exception->errorBag->first();
            }
            $res = ['error' => $errorBag];
            return response(json_encode($res, JSON_UNESCAPED_UNICODE), $exception->status);
        }
        if ($exception instanceof AuthenticationException) {
            $res = ['error' => $exception->getMessage()];
            return response(json_encode($res, JSON_UNESCAPED_UNICODE), 401);
        }
        if ($this->isHttpException($exception)) {
            return response(null, $exception->getStatusCode());
        }
        $status = $exception->getCode();
        if ($status === 0) {
            if (is_object($exception) && method_exists($exception, 'getStatusCode')) {
                $status = $exception->getStatusCode();
            } elseif (isset($exception->status)) {
                $status = $exception->status;
            }
        }
        if (empty($status)) {
            return response(null, 500);
        }
        return response(null, $status);
    }

    /**
     * 決済サーバーの例外処理
     *
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function renderForPayment()
    {
        return response(0, 200)->header('Content-Type', 'text/plain');
    }

    /**
     * 決済サーバーの返却値で再通知をリクエスト
     *
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function retryForPayment()
    {
        return response(1, 200)->header('Content-Type', 'text/plain');
    }
}
