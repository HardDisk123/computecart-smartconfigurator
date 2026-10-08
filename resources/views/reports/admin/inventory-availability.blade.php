@extends('reports.layout')

@section('content')
<h2>Inventory Availability Report</h2>
<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock Units</th>
            <th>Availability Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name ?? 'Unassigned' }}</td>
            <td>₱{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                @if($product->stock > 5)
                    <span class="badge-success">In Stock</span>
                @elseif($product->stock > 0)
                    <span style="color: orange; font-weight: bold;">Low Stock</span>
                @else
                    <span class="badge-danger">Out of Stock</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection