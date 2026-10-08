@extends('reports.layout')

@section('content')
<h2>Alternative Parts Comparison Report</h2>
<p>This report highlights suggested alternative hardware components matching your target build performance and budget tier.</p>

<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Comparison Summary</th>
        </tr>
    </thead>
    <tbody>
        @forelse($alternatives as $product)
        <tr>
            <td><strong>{{ $product->name }}</strong></td>
            <td>{{ $product->category->name ?? 'Hardware' }}</td>
            <td>${{ number_format($product->price ?? 0, 2) }}</td>
            <td>Alternative option within target performance margin.</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No alternative parts available for comparison.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection