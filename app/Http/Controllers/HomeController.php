<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{

public function index()
{
    $categories = Category::all();

    // Get all products with category
    $products = Product::with('category')->get();

    // Get unique statuses (labels) for filter buttons
    $labels = Product::select('status')->distinct()->pluck('status')->filter();

    return view('user.home', compact('categories', 'products', 'labels'));
}


}
