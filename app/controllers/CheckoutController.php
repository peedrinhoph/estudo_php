<?php

namespace app\controllers;

use Exception;
use app\library\Config;
use Stripe\StripeClient;
use app\library\Redirect;
use app\services\AuthInfoService;
use app\services\CartInfoService;
use app\services\CheckoutService;

class CheckoutController
{
    public function checkout()
    {
        try {

            $checkoutService = new CheckoutService;
            $checkout_session = $checkoutService->checkout();
            
            Redirect::to($checkout_session->url);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
