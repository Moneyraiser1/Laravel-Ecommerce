<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show cart items
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('user.cart', compact('cartItems'));
    }

    // Add product to cart
    public function add(Request $request, Product $product)
    {
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id'       => Auth::id(),
                'product_id'    => $product->id,
                'product_name'  => $product->name,
                'product_image' => is_array($product->images) ? ($product->images[0] ?? null) : null,
                'price'         => $product->price,
                'quantity'      => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'quantity' => ['required', 'integer', 'min:1'],
    ]);

    $cartItem = Cart::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $cartItem->quantity = $validated['quantity'];
    $cartItem->save();

    $subtotal = Cart::where('user_id', Auth::id())->get()
        ->sum(fn($item) => $item->price * $item->quantity);

    if ($request->ajax()) {
        return response()->json([
            'itemTotal' => number_format($cartItem->price * $cartItem->quantity, 2),
            'subtotal'  => number_format($subtotal, 2),
        ]);
    }

    return back()->with('success', 'Cart updated.');
}


public function remove($id)
{
    Cart::where('id', $id)->where('user_id', Auth::id())->delete();

    $subtotal = Cart::where('user_id', Auth::id())->get()
        ->sum(fn($item) => $item->price * $item->quantity);

    return response()->json([
        'subtotal' => number_format($subtotal, 2),
    ]);
}

}
