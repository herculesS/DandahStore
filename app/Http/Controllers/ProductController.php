<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;

class ProductController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    function index() {

        $data = [
            'name' => 'Relogio Masc',
        ];

        $product = new product();

        $products = Product::all();
        return view('admin.products', compact('products'));
    }
}
