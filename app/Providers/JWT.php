<?php

namespace App\Provider;

use Dingo\Api\Auth\Provider\JWT as JWTProvider;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JWT extends JWTProvider
{

    /**
     * Authenticate request with a JWT.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Dingo\Api\Routing\Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        $token = $this->getToken($request);
        $modelName = $route->getAction('model');

        try {

            if ($modelName && !$user = $this->auth->setToken($token)->checkSubjectModel($modelName)) {
                throw new UnauthorizedHttpException('JWTAuth', 'Unable to authenticate with invalid model.');
            }

            if (!$user = $this->auth->setToken($token)->authenticate()) {
                throw new UnauthorizedHttpException('JWTAuth', 'Unable to authenticate with invalid token.');
            }
        } catch (JWTException $exception) {
            throw new UnauthorizedHttpException('JWTAuth', $exception->getMessage(), $exception);
        }

        return $user;


    }

}
