<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items.product')->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();
        $totalCustomers = User::count();
        $totalProducts = Product::count();

        // Top 5 buyers
        $topBuyers = User::withSum('orders', 'total')
            ->orderByDesc('orders_sum_total')
            ->take(5)
            ->get()
            ->map(fn($u) => [
                'name' => $u->name,
                'total_spent' => $u->orders_sum_total ?? 0,
            ]);

        // Monthly sales
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(fn($m) => [
                'month' => date('F', mktime(0, 0, 0, $m->month, 1)),
                'total' => $m->total,
            ]);

        // Most popular products
        $popularProducts = OrderItem::selectRaw('product_id, SUM(quantity) as quantity_sold')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('quantity_sold')
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'name' => $p->product->name,
                'quantity_sold' => $p->quantity_sold,
            ]);

        return view('admin.home', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'totalProducts',
            'topBuyers',
            'monthlySales',
            'popularProducts'
        ));
    }
}
