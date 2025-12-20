@extends('layouts.adminlayout')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    $('#recentOrdersTable').DataTable();

    // Monthly Sales Chart
    const salesCtx = document.getElementById('visit-sale-chart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlySales->pluck('month')) !!},
            datasets: [{
                label: 'Sales',
                data: {!! json_encode($monthlySales->pluck('total')) !!},
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Traffic / Top Buyers Pie Chart
    const trafficCtx = document.getElementById('traffic-chart').getContext('2d');
    new Chart(trafficCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($topBuyers->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode($topBuyers->pluck('total_spent')) !!},
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
});
</script>
@endsection

@section('main-content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Revenue <i class="mdi mdi-chart-line mdi-24px float-end"></i></h4>
                <h2 class="mb-5">₦{{ number_format($totalRevenue,2) }}</h2>
                <h6 class="card-text">Compared to last month</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Orders <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalOrders }}</h2>
                <h6 class="card-text">Compared to last month</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Customers <i class="mdi mdi-diamond mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalCustomers }}</h2>
                <h6 class="card-text">Compared to last month</h6>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <h4 class="card-title float-start">Visit And Sales Statistics</h4>
                </div>
                <canvas id="visit-sale-chart" class="mt-4"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Top Buyers</h4>
                <canvas id="traffic-chart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
