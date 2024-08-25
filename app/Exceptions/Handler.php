<?php

namespace App\Exceptions;

use App\Commons\RespDef;
use App\Utils\RespUtil;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use PDOException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        // 如果异常抛出时在事务中，需要手动回滚事务
        if (DB::transactionLevel() > 0) {
            DB::rollBack();
        }

        if ($this->shouldntReport($exception)) {
            return;
        }

        if ($exception instanceof PDOException) {
            Log::channel('sql_error')->error($exception->getMessage() . "\n" . $exception);
        } else {
            Log::channel('error')->error($exception->getMessage() . "\n" . $exception);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return RespUtil::json(RespDef::CODE_NO_API, RespDef::MSG_NO_API, null, 404);
        }

        if ($exception instanceof PDOException) {
            return RespUtil::json(RespDef::CODE_DB_ERROR, $exception->getMessage(), null, 500);
        }

        if (config('app.debug', false)) {
            return RespUtil::json($exception->getCode() ?: RespDef::CODE_SYSTEM_ERROR, $exception->getMessage());
        }
        return RespUtil::json($exception->getCode() ?: RespDef::CODE_SYSTEM_ERROR, null);
    }
}
