<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Products</h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6">
        @forelse($products as $product)
            <div class="border rounded-lg shadow-sm hover:shadow-lg transition bg-white flex flex-col product-card">
                <!-- Product Image with Overlay -->
                <a href="{{ route('products.show', $product) }}" class="product-link">
                    <img src="{{ $product->image_url ?? 'https://via.placeholder.com/400x250' }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-48 object-cover rounded-t-lg">
                    <span class="overlay-text">{{ $product->name }}</span>
                </a>

                <!-- Product Info -->
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-lg font-bold mb-1">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-1">₱{{ number_format($product->price, 2) }}</p>
                    <p class="text-sm text-gray-500 mb-3">{{ $product->category->name }}</p>

                    <!-- Actions -->
                    <div class="mt-auto space-x-2">
                        <a href="{{ route('products.show', $product) }}" 
                           class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                           View
                        </a>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" 
                                    class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500">No products available at the moment.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="px-6 pb-6">
        {{ $products->links() }}
    </div>

    <!-- ✅ Inline CSS for Product Listing -->
    <style>
        .product-link {
            position: relative;
            display: inline-block;
            overflow: hidden;
            border-radius: 6px 6px 0 0;
            text-decoration: none;
        }
        .product-link img {
            display: block;
            transition: filter 0.4s ease, transform 0.4s ease;
        }
        .product-link .overlay-text {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            opacity: 0;
            transition: all 0.4s ease;
            text-shadow: 0 0 8px rgba(255,255,255,0.8);
            pointer-events: none;
        }
        .product-link:hover img {
            filter: brightness(0.2);
            transform: scale(1.08);
        }
        .product-link:hover .overlay-text {
            opacity: 1;
            top: 50%;
        }

        /* Product Card Hover */
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }
    </style>
</x-app-layout>
