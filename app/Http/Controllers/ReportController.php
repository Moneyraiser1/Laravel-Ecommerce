<?php
// app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ReportController extends Controller
{
public function index()
{
    $orders = \App\Models\Order::with('user', 'items.product')->where('payment_status', 'success')->orderBy('created_at', 'desc')->get();

    // Top 5 buyers by total spent
    $topBuyers = \App\Models\User::withSum('orders', 'total')
        ->orderByDesc('orders_sum_total')
        ->take(5)
        ->get()
        ->map(fn($u) => [
            'name' => $u->name,
            'total_spent' => $u->orders_sum_total ?? 0,
        ]);

    // Monthly sales
    $monthlySales = \App\Models\Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->map(fn($m) => [
            'month' => date('F', mktime(0, 0, 0, $m->month, 1)), // convert month number to name
            'total' => $m->total,
        ]);

    // Most popular products by quantity sold
    $popularProducts = \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as quantity_sold')
        ->with('product')
        ->groupBy('product_id')
        ->orderByDesc('quantity_sold')
        ->take(5)
        ->get()
        ->map(fn($p) => [
            'name' => $p->product->name,
            'quantity_sold' => $p->quantity_sold,
        ]);

    return view('admin.report', [
        'orders' => $orders,
        'totalRevenue' => $orders->sum('total'),
        'totalOrders' => $orders->count(),
        'totalCustomers' => \App\Models\User::where('role', 'user')->get()->count(),
        'totalProducts' => \App\Models\Product::count(),
        'topBuyers' => $topBuyers,
        'monthlySales' => $monthlySales,
        'popularProducts' => $popularProducts,
    ]);
}
 

    public function show($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);

        return response()->json($order);
    }
}
