@extends('reports.layout')

@section('content')
<h2>Budget Allocation Report</h2>
<p><strong>Customer Name:</strong> {{ $user->name ?? 'User' }}</p>

@if($order)
    <p><strong>Order ID:</strong> #{{ $order->id }} | <strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <table>
        <thead>
            <tr>
                <th>Component / Item</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name ?? 'Hardware Component' }}</td>
                <td>{{ $item->product->category->name ?? 'N/A' }}</td>
                <td>{{ $item->quantity ?? 1 }}</td>
                <td>₱{{ number_format($item->price ?? $item->product->price ?? 0, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Total Allocated Cost:</th>
                <th>₱{{ number_format($order->total, 2) }}</th>
            </tr>
        </tfoot>
    </table>
@else
    <p style="color: #666;">No recorded completed build orders found for this account.</p>
@endif
@endsection