@extends('reports.layout')

@section('content')
<h2>Build History Report</h2>
<table>
    <thead>
        <tr>
            <th>Order #</th>
            <th>Date Saved / Placed</th>
            <th>Items Included</th>
            <th>Status</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr>
            <td>#{{ $order->id }}</td>
            <td>{{ $order->created_at->format('M d, Y') }}</td>
            <td>{{ $order->items->count() }} Component(s)</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>₱{{ number_format($order->total, 2) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No build history recorded.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection