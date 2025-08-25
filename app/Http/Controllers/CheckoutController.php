<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cartItems = DB::table('carts')
            ->where('user_id', $user->id)
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('carts.*', 'products.name', 'products.price', 'products.images')
            ->get();

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->price);

        return view('user.checkout', compact('cartItems', 'total', 'user'));
    }

    /**
     * (Optional) Manual checkout without Paystack
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $request->total,
                'payment_status' => 'success',
                'reference' => Str::uuid(),
            ]);

            $cartItems = DB::table('carts')
                ->where('user_id', $user->id)
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->select('carts.*', 'products.price')
                ->get();

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                Product::where('id', $item->product_id)
                    ->decrement('stock', $item->quantity);
            }

            DB::table('carts')->where('user_id', $user->id)->delete();
            DB::commit();

            // Send confirmation email
            Mail::to($user->email)->send(new OrderPlacedMail($order));

            return redirect()->route('checkout.success', $order->reference)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    /**
     * Initialize Paystack payment
     */
    public function initialize(Request $request)
    {
        $user = Auth::user();
        $amount = $request->input('amount'); // in Naira

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->post('https://api.paystack.co/transaction/initialize', [
                'amount' => $amount * 100, // Paystack expects kobo
                'email' => $user->email,
                'reference' => uniqid('trx_'),
                'callback_url' => route('checkout.callback'),
                'metadata' => [
                    'user_id' => $user->id
                ],
            ]);

        $data = $response->json();
            
        if ($data['status']) {
            return redirect($data['data']['authorization_url']);
        }

        return back()->with('error', 'Unable to initialize payment.');
    }

    /**
     * Paystack callback → verify payment & create order
     */
 public function callback(Request $request)
{
    $reference = $request->reference ?? $request->input('reference');

    if (!$reference) {
        return redirect()->route('checkout.index')->with('error', 'No reference supplied.');
    }

    $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
        ->get("https://api.paystack.co/transaction/verify/{$reference}");

    $data = $response->json();

    if ($data['status'] && $data['data']['status'] === 'success') {
        $userId = $data['data']['metadata']['user_id'];
        $user = User::findOrFail($userId);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $data['data']['amount'] / 100,
                'payment_status' => 'paid',
                'reference' => $reference,
            ]);

            $cartItems = DB::table('carts')
                ->where('user_id', $user->id)
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->select('carts.*', 'products.price')
                ->get();

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
                Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
            }

            DB::table('carts')->where('user_id', $user->id)->delete();
            DB::commit();

            Mail::to($user->email)->send(new OrderPlacedMail($order));
           return redirect()->route('checkout.success', ['reference' => $reference])
    ->with('success', 'Payment verification successful.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    return redirect()->route('checkout.index')->with('error', 'Payment verification failed.');
}

    public function success($reference)
    {
        $order = Order::where('reference', $reference)->firstOrFail();
        return view('user.success', compact('order'));
    }
}
