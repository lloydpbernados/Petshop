<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // This looks for resources/views/shop.blade.php
        return view('customer.shop');
    }
}