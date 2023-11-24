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

            $ENV = Config::getEnv();
            $stripe = new StripeClient($ENV['STRIPE_KEY']);

            $baseUrl = $ENV['BASE_URL'];
            $items = [
                'mode' => 'payment',
                'success_url' => "{$baseUrl}/success",
                'cancel_url' => "{$baseUrl}/cancel",
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
