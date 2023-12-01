<?php

namespace app\middlewares;

use app\services\AuthService as ServiceAuth;
use app\interfaces\MiddlewareInterface;
use app\library\Redirect;

class Auth implements MiddlewareInterface
{
    public function execute()
    {
        if (!ServiceAuth::isAuth()) {
            return Redirect::to('/');
        }
    }
}
