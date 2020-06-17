<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index() {
        // $data = [
        //     'name' => 'Relogio Fem',
        // ];

        //  $product = category::create($data);

        $categories = Category::all();

        return view('admin.categories', compact('categories'));
    }

    function create() {
        return view('admin.create.category');
    }
}
