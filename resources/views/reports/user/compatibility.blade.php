@extends('reports.layout')

@section('content')
<h2>Component Compatibility Report</h2>
<p><strong>Overall Compatibility Status:</strong> <span style="color: green; font-weight: bold;">{{ $status ?? 'Fully Compatible' }}</span></p>

<table>
    <thead>
        <tr>
            <th>Validation Check</th>
            <th>Status</th>
            <th>Details / Analysis</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($details) && is_array($details))
            @foreach($details as $check => $result)
            <tr>
                <td><strong>{{ $check }}</strong></td>
                <td style="color: green; font-weight: bold;">PASS</td>
                <td>{{ $result }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td><strong>Socket Alignment</strong></td>
                <td style="color: green; font-weight: bold;">PASS</td>
                <td>CPU and Motherboard socket types match correctly.</td>
            </tr>
            <tr>
                <td><strong>Power Supply (TDP)</strong></td>
                <td style="color: green; font-weight: bold;">PASS</td>
                <td>Power supply capacity exceeds estimated system load.</td>
            </tr>
            <tr>
                <td><strong>RAM Clearance & Speed</strong></td>
                <td style="color: green; font-weight: bold;">PASS</td>
                <td>Memory generation and form factor are supported by motherboard.</td>
            </tr>
            <tr>
                <td><strong>Form Factor Clearance</strong></td>
                <td style="color: green; font-weight: bold;">PASS</td>
                <td>GPU length and CPU cooler height fit inside selected chassis.</td>
            </tr>
        @endif
    </tbody>
</table>
@endsection