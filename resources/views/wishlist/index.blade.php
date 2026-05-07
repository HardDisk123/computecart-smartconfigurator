<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">My Wishlist</h2>
    </x-slot>

    <div class="p-6">
        @if($wishlists->isEmpty())
            <p>Your wishlist is empty.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($wishlists as $product)
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                        <p>₱{{ number_format($product->price, 2) }}</p>

                        <!-- Move to Cart -->
                        <form action="{{ route('wishlist.moveToCart', $product->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Move to Cart
                            </button>
                        </form>

                        <!-- Remove from Wishlist -->
                        <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST" class="inline ml-2">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
