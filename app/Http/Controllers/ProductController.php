<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\Auth; use App\Models\Cart;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::all();               // Fetch all products
    $categories = CategoryModel::all(); // Fetch all categories
    return view('admin.product', compact('products', 'categories'));
}


public function userindex()
{
    $products = Product::all();
    $categories = CategoryModel::all();

    $cartProductIds = [];

    if (Auth::check()) {
        $cartProductIds = Cart::where('user_id', Auth::id())
                            ->pluck('product_id')
                            ->toArray();
    }

    return view('user.product', compact('products', 'categories', 'cartProductIds'));
}


public function category($id)
{
    $categories = CategoryModel::all();
    $selectedCategory = CategoryModel::findOrFail($id);
    $products = $selectedCategory->products; // Assuming Category hasMany Products

    $cartProductIds = [];
    if (Auth::check()) {
        $cartProductIds = Cart::where('user_id', Auth::id())
                            ->pluck('product_id')
                            ->toArray();
    }

    return view('user.product', compact('categories', 'products', 'selectedCategory', 'cartProductIds'));
}


public function show($id)
{
    $product = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.category as category_name')
        ->where('products.id', $id)
        ->firstOrFail();

    return response()->json($product);
}


public function showuser($id)
{
    $product = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.category as category_name')
        ->where('products.id', $id)
        ->firstOrFail();

    // Convert images JSON string to PHP array (if stored as JSON)
    if (is_string($product->images)) {
        $product->images = json_decode($product->images, true);
    }

    return view('user.product-details', compact('product'));
}
// ProductController.php

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'images.*' => 'nullable|image|max:2048',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required|integer|exists:categories,id', // FIXED
        'status' => 'required|string|max:50',
        'description' => 'nullable|string',
    ]);

    $imageNames = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $filename);
            $imageNames[] = $filename;
        }
    }

    Product::create([
        'name' => $request->name,
        'images' => $imageNames,
        'price' => $request->price,
        'stock' => $request->stock,
        'category_id' => $request->category_id, // FIXED
        'status' => $request->status,
        'description' => $request->description,
    ]);

    return redirect()->back()->with('success', 'Product added successfully!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'images.*' => 'nullable|image|max:2048',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required|integer|exists:categories,id', // FIXED
        'status' => 'required|string|max:50',
    ]);

    $product = Product::findOrFail($id);

    $imageNames = $product->images;

    if ($request->hasFile('images')) {
        $imageNames = [];
        foreach ($request->file('images') as $image) {
            $filename = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads'), $filename);
            $imageNames[] = $filename;
        }
    }

    $product->update([
        'name' => $request->name,
        'images' => $imageNames,
        'price' => $request->price,
        'stock' => $request->stock,
        'category_id' => $request->category_id, // FIXED
        'status' => $request->status,
    ]);

    return redirect()->route('admin.product')->with('success','Product updated successfully');
}

public function edit($id)
{
    $product    = Product::findOrFail($id);
    $categories = CategoryModel::all();

    return view('admin.product_edit', compact('product', 'categories'));
}


public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return back()->with('success','Product deleted successfully');
}
  
}
