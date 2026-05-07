<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Order #{{ $order->id }}</h2>
    </x-slot>

    <div class="p-6">
        <h3 class="text-lg font-bold">Order Details</h3>
        <p>Status: <span class="font-semibold">{{ $order->status }}</span></p>
        <p>Total: ₱{{ $order->total }}</p>

        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Product</th>
                    <th class="p-2">Quantity</th>
                    <th class="p-2">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="border-b">
                        <td class="p-2">{{ $item->product->name }}</td>
                        <td class="p-2">{{ $item->quantity }}</td>
                        <td class="p-2">₱{{ $item->price * $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('products.index') }}" 
           class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
           Continue Shopping
        </a>
    </div>
</x-app-layout>