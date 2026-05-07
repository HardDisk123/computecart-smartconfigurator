@extends('layouts.app') <!-- unified layout with main app navbar -->

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <aside id="adminSidebar" class="col-md-3 col-lg-2 min-vh-100 p-3">
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
            <!-- Sidebar Toggle (visible on small screens) -->
            <button class="btn btn-outline-light d-md-none mb-3" type="button" 
                    data-bs-toggle="collapse" data-bs-target="#adminSidebar" aria-expanded="false">
                <i class="bi bi-list"></i> Menu
            </button>

            @yield('admin-content')
        </main>
    </div>
</div>

<!-- ✅ Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
@endsection
