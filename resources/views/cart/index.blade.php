<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">My Shopping Cart</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($cart->items->isEmpty())
            <div class="bg-white p-8 rounded-xl shadow-sm text-center border border-gray-100">
                <p class="text-gray-500 text-lg font-medium">Your cart is currently empty.</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Left: Cart Items Table (2 Columns wide) -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full table-fixed border-collapse">
                            <thead>
                                <tr class="bg-black text-white text-xs uppercase tracking-wider">
                                    <th class="p-4 text-left w-1/2">Product</th>
                                    <th class="p-4 text-center w-1/6">Quantity</th>
                                    <th class="p-4 text-right w-1/6">Price</th>
                                    <th class="p-4 text-center w-1/6">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm bg-white">
                                @foreach($cart->items as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <!-- Product Details -->
                                        <td class="p-4 align-middle">
                                            <div class="flex items-center space-x-3">
                                                @if(isset($item->product->image))
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="w-12 h-12 object-cover rounded-lg border border-gray-200 shrink-0">
                                                @endif
                                                <div class="min-w-0 flex-1">
                                                    <p class="font-semibold text-gray-900 truncate">{{ $item->product->name }}</p>
                                                    <p class="text-xs text-gray-500">₱{{ number_format($item->product->price, 2) }} each</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Quantity -->
                                        <td class="p-4 text-center align-middle font-medium text-gray-700">
                                            <span class="inline-block bg-gray-100 px-3 py-1 rounded-md text-xs font-semibold">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>

                                        <!-- Total Price per Item -->
                                        <td class="p-4 text-right align-middle font-bold text-gray-900">
                                            ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                                        </td>

                                        <!-- Action -->
                                        <td class="p-4 text-center align-middle">
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-md glow-btn transition-all">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Order Summary Panel (1 Column wide) -->
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 pb-3 border-b border-gray-200">Order Summary</h3>
                    
                    <div class="space-y-3 py-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Total Items</span>
                            <span class="font-semibold text-gray-900">{{ $cart->items->sum('quantity') }}</span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-gray-900 pt-3 border-t border-gray-100">
                            <span>Estimated Total</span>
                            <span class="text-xl text-emerald-600">
                                ₱{{ number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 2) }}
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('orders.checkout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg glow-btn tracking-wide transition-all">
                            Proceed to Checkout
                        </button>
                    </form>
                </div>

            </div>
        @endif
    </div>

    <!-- ✅ Custom CSS for Glow Effects -->
    <style>
        .glow-btn {
            transition: box-shadow 0.25s ease, transform 0.2s ease, background-color 0.25s ease;
        }
        .glow-btn:hover {
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-1px);
        }
    </style>
</x-app-layout>