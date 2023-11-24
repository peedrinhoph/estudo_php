<?php

namespace app\controllers;

use Exception;
use app\library\Auth;
use app\library\Config;
use Stripe\StripeClient;
use app\library\CartInfo;
use app\library\Redirect;

class CheckoutController
{
    public function checkout()
    {
        try {

            if (!Auth::auth()) {
                throw new Exception("Para fazer o checkout você precisa estar logado");
            }

            $stripe = new StripeClient(Config::getEnv()['STRIPE_KEY']);

            // $baseUrl = $ENV['BASE_URL'];
            $items = [
                'mode' => 'payment',
                'success_url' => "http://localhost:80/success",
                'cancel_url' => "http://localhost:80/cancel",
            ];

            foreach (CartInfo::getCart() as $product) {
                $items['line_items'][] = [
                    'price_data' => [
                        'currency' => 'brl',
                        'product_data' => [
                            'name' => $product->getName()
                        ],
                        'unit_amount' => $product->getPrice() * 100
                    ],
                    'quantity' => $product->getQuantity()
                ];
            }

            $checkout_session = $stripe->checkout->sessions->create($items);

            Redirect::to($checkout_session->url);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
