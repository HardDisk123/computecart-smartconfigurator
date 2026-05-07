<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">My Cart</h2>
    </x-slot>

    <div class="p-6">
        @if($cart->items->isEmpty())
            <p>Your cart is empty.</p>
        @else
            <table class="w-full border-collapse shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="p-3 text-left">Product</th>
                        <th class="p-3 text-left">Quantity</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($cart->items as $item)
                        <tr class="border-b">
                            <td class="p-3">{{ $item->product->name }}</td>
                            <td class="p-3">{{ $item->quantity }}</td>
                            <td class="p-3">₱{{ $item->product->price * $item->quantity }}</td>
                            <td class="p-3">
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded glow-btn">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('orders.checkout') }}" method="POST" class="mt-4">
                @csrf
                <button class="px-4 py-2 bg-green-600 text-white rounded glow-btn">
                    Checkout
                </button>
            </form>
        @endif
    </div>

    <!-- ✅ Inline CSS for Cart -->
    <style>
        /* Buttons with Hover Effects */
        .glow-btn {
            transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
        }
        .glow-btn:hover {
            box-shadow: 0 0 10px rgba(255,255,255,0.9);
            transform: scale(1.05);
            background-color: #333; /* darker shade on hover */
            color: #fff;
        }
    </style>
</x-app-layout>
