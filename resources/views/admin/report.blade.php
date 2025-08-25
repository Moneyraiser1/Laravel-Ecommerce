@extends('layouts.adminlayout')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .stat-card {
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        padding: 1rem;
        text-align: center;
    }
    .stat-card h3 { margin-bottom: 0; font-weight: 700; }
    .stat-card p { margin: 0; color: #6c757d; }
</style>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function () {
    $('#reportTable').DataTable();

    // View Order Modal
    $(document).on('click', '.btn-view', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        $.get('{{ route("admin.report.show", ":id") }}'.replace(':id', id), function(order) {
            $('#view-id').text(order.id);
            $('#view-user').text(order.user.name);
            $('#view-total').text(order.total);
            $('#view-status').text(order.payment_status);

            const ctx = document.getElementById('orderChart').getContext('2d');
            const labels = order.items.map(item => item.product.name);
            const data = order.items.map(item => item.quantity);

            if(window.orderChart) window.orderChart.destroy();
            window.orderChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Quantity',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: { scales: { y: { beginAtZero: true } } }
            });

            $('#viewOrderModal').modal('show');
        });
    });

    // Top Buyers Chart
    const topBuyersCtx = document.getElementById('topBuyersChart').getContext('2d');
    const topBuyersData = @json($topBuyers); // array of {name, total_spent}
    new Chart(topBuyersCtx, {
        type: 'bar',
        data: {
            labels: topBuyersData.map(b => b.name),
            datasets: [{
                label: 'Total Spent (₦)',
                data: topBuyersData.map(b => b.total_spent),
                backgroundColor: 'rgba(255, 159, 64, 0.5)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // Monthly Sales Chart
    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    const monthlySalesData = @json($monthlySales); // array of {month, total}
    new Chart(monthlySalesCtx, {
        type: 'line',
        data: {
            labels: monthlySalesData.map(m => m.month),
            datasets: [{
                label: 'Sales per Month (₦)',
                data: monthlySalesData.map(m => m.total),
                fill: false,
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.1
            }]
        },
        options: { responsive: true }
    });

    // Most Popular Products Chart
    const popularCtx = document.getElementById('popularProductsChart').getContext('2d');
    const popularData = @json($popularProducts); // array of {name, quantity_sold}
    new Chart(popularCtx, {
        type: 'pie',
        data: {
            labels: popularData.map(p => p.name),
            datasets: [{
                label: 'Quantity Sold',
                data: popularData.map(p => p.quantity_sold),
                backgroundColor: [
                    '#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#FF9F40'
                ],
            }]
        },
        options: { responsive: true }
    });
});
</script>
@endsection

@section('main-content')
<div class="container py-4">

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-light">
                <h3>₦{{ number_format($totalRevenue) }}</h3>
                <p>Total Revenue</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-light">
                <h3>{{ $totalOrders }}</h3>
                <p>Total Orders</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-light">
                <h3>{{ $totalCustomers }}</h3>
                <p>Total Customers</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-light">
                <h3>{{ $totalProducts }}</h3>
                <p>Total Products</p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold">Top Buyers</h5>
                    <canvas id="topBuyersChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold">Monthly Sales</h5>
                    <canvas id="monthlySalesChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold">Most Popular Products</h5>
                    <canvas id="popularProductsChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-semibold mb-4">All Orders</h5>
            <table id="reportTable" class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>₦{{ number_format($order->total) }}</td>
                        <td>{{ ucfirst($order->payment_status) }}</td>
                        <td>{{ ucfirst($order->created_at) }}</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-dark btn-view" data-id="{{ $order->id }}">View</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Order ID:</strong> <span id="view-id"></span></p>
                <p><strong>User:</strong> <span id="view-user"></span></p>
                <p><strong>Total:</strong> ₦<span id="view-total"></span></p>
                <p><strong>Status:</strong> <span id="view-status"></span></p>
                <canvas id="orderChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
