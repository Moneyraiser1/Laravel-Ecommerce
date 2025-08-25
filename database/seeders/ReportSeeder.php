<?php
// database/seeders/OrderSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class ReportSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $products = Product::all();

      foreach ($users as $user) {
    // Create 1-3 orders per user
    $orderCount = rand(1, 3);
    for ($i = 0; $i < $orderCount; $i++) {
        $order = Order::create([
            'user_id' => $user->id,
            'total' => 0, // will calculate after items
            'payment_status' => ['pending','completed','failed'][rand(0,2)],
            'reference' => 'ORD-' . strtoupper(uniqid()),
        ]);

        // Add 1-5 random items per order
        $itemCount = rand(1, 5);
        $total = 0;

        for ($j = 0; $j < $itemCount; $j++) {
            // **Place your snippet here**
            $product = $products->random();
            $quantity = rand(1, 3);
            $price = $product->selling_price ?? 0; // ensure no null
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
            $total += $price * $quantity;
        }

        // Update order total after adding all items
        $order->update(['total' => $total]);
    }
}

    }
}
