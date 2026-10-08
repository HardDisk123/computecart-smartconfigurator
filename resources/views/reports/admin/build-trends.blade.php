@extends('reports.layout')

@section('content')
<h2>Popular Build Trends Report</h2>
<table>
    <thead>
        <tr>
            <th>Rank</th>
            <th>Component Name</th>
            <th>Category</th>
            <th>Total Times Purchased</th>
            <th>Unit Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr>
            <td><strong>#{{ $index + 1 }}</strong></td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name ?? 'Hardware' }}</td>
            <td>{{ $product->order_items_count }} build(s)</td>
            <td>₱{{ number_format($product->price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection