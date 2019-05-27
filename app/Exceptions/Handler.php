<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpKernel\Exception\HttpException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Tymon\JWTAuth\Exceptions\TokenExpiredException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException::class,
        \Spatie\Permission\Exceptions\UnauthorizedException::class,
        \Dingo\Api\Exception\RateLimitExceededException::class,
        \Dingo\Api\Exception\ValidationHttpException::class,
        \Tymon\JWTAuth\Exceptions\TokenExpiredException::class,

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
     * @param Exception $exception
     * @return mixed
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception) && env('APP_ENV') == 'production') {
            $str = $exception->getMessage() . PHP_EOL . $exception->getFile() . PHP_EOL . $exception->getLine();
            if (request() && request()->route()) {
                $route = request()->route();
                $str .= "\n" . "完整URL: " . URL::current()
                    . "\n" . "请求方式: " . ($route->methods ? implode(',', $route->methods ?? []) : "");

            }
//            ding()->with('other')->text($str);
        }

        return parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws AuthenticationException
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof HttpException && $request->segment(1) === 'horizon') {
            throw new AuthenticationException;
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
