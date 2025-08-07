<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     * Display featured products and welcome message.
     */
    public function index()
    {
        // Get active products for the homepage
        $products = Product::active()->take(6)->get();

        return view('home', compact('products'));
    }

    /**
     * Show the return policy page.
     */
    public function returnPolicy()
    {
        return view('return-policy');
    }
}
