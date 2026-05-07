@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3 col-lg-2 min-vh-100 p-3">
            <div class="card bg-black text-white shadow-lg border-0 h-100 d-flex flex-column">
                <div class="card-header fw-bold fs-5">Admin Menu</div>
                <div class="card-body p-0 flex-grow-1 overflow-auto">
                    <ul class="nav flex-column">
                        @foreach([
                            ['route'=>'admin.dashboard','icon'=>'speedometer2','label'=>'Dashboard'],
                            ['route'=>'admin.products.index','icon'=>'box-seam','label'=>'Products'],
                            ['route'=>'admin.categories.index','icon'=>'tags','label'=>'Categories'],
                            ['route'=>'admin.orders.index','icon'=>'bag-check','label'=>'Orders'],
                            ['route'=>'admin.users.index','icon'=>'people','label'=>'Customers'],
                            ['route'=>'admin.reviews.index','icon'=>'chat-square-text','label'=>'Reviews'],
                        ] as $item)
                            <li class="nav-item mb-1">
                                <a href="{{ route($item['route']) }}"
                                   class="nav-link text-white {{ request()->routeIs($item['route'].'*') ? 'active fw-bold text-info' : '' }}">
                                    <i class="bi bi-{{ $item['icon'] }} me-1"></i> {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 py-5">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Admin Dashboard</h2>
                <a href="{{ route('admin.products.create') }}" class="btn btn-dark glow-btn">
                    <i class="bi bi-plus-circle me-1"></i> Add Product
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-5">
                @foreach([
                    ['label'=>'Products','value'=>$stats['products']],
                    ['label'=>'Orders','value'=>$stats['orders']],
                    ['label'=>'Customers','value'=>$stats['customers']],
                    ['label'=>'Reviews','value'=>$stats['reviews']],
                ] as $stat)
                    <div class="col-md-3">
                        <div class="card shadow-lg border-0 text-center">
                            <div class="card-body">
                                <h6 class="text-muted">{{ $stat['label'] }}</h6>
                                <h2 class="fw-bold">{{ $stat['value'] }}</h2>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Charts -->
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Products by Category</h5>
                            <canvas id="productsChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Orders Overview</h5>
                            <canvas id="ordersChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Growth -->
            <div class="card shadow-lg border-0 mb-5">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Customer Growth</h5>
                    <canvas id="customerChart"></canvas>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card shadow-lg border-0 mb-5">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Recent Orders</h5>
                    @if($recentOrders->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>₱{{ number_format($order->total, 2) }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No recent orders.</p>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Products by Category Chart (Gradient Bar)
    new Chart(document.getElementById('productsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($productCounts->keys()) !!},
            datasets: [{
                label: 'Products',
                data: {!! json_encode($productCounts->values()) !!},
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ],
                borderRadius: 8
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Orders Overview Chart (Smooth Line with Fill)
    new Chart(document.getElementById('ordersChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($ordersPerMonth->keys()) !!},
            datasets: [{
                label: 'Orders',
                data: {!! json_encode($ordersPerMonth->values()) !!},
                borderColor: 'rgba(255, 99, 132, 0.9)',
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Customer Growth Chart (Line with Gradient Fill)
    new Chart(document.getElementById('customerChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($customerGrowth->keys()) !!},
            datasets: [{
                label: 'Customers',
                data: {!! json_encode($customerGrowth->values()) !!},
                borderColor: 'rgba(75, 192, 192, 0.9)',
                backgroundColor: 'rgba(75, 192, 192, 0.3)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endpush

<!-- ✅ Inline CSS -->
<style>
    .glow-btn {
        transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
    }
    .glow-btn:hover {
        box-shadow: 0 0 12px rgba(255,255,255,0.9);
        transform: scale(1.05);
        background-color: #333;
        color: #fff;
    }
    .nav-link.active {
        background-color: rgba(255,255,255,0.15);
        border-radius: 6px;
    }
    .nav-link:hover {
        background-color: rgba(255,255,255,0.25);
        border-radius: 6px;
    }
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>
