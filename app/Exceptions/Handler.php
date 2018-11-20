<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;


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
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {

        if ($this->shouldReport($exception) && env('APP_ENV') == 'production') {

            $official_account = app('wechat.official_account');
            $official_account->template_message->send([
                'touser' => 'oNN6q0pq-f0-Z2E2gb0QeOmY4r-M',
                'template_id' => 'tEaeatGQCZ7tanD4JuFIoddvw8dgWMAYmQcYkjrGWfs',
                'data' => [
                    'first' => '服务器出错，请尽快修复',
                    'keyword1' => request()->url(),
                    'keyword2' => $exception->getFile(),
                    'keyword3' => $exception->getLine(),
                    'keyword4' => date('Y-m-d H:i:s'),
                    'remark' => $exception->getMessage(),
                ]
            ]);
        }

        return parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
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

        $route = $request->segment(1) === 'admin'
            ? route('admin.login')
            : route('front.login');

        return redirect()->guest($route);
    }
}
