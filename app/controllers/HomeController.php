<?php

namespace app\controllers;

use app\core\View;
use app\database\models\Product;

class HomeController
{
    public function index()
    {
        $products = Product::all();
        View::render('home', ['products' => $products]);
    }
}
