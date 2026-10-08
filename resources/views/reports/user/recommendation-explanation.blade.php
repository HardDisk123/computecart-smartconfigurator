@extends('reports.layout')

@section('content')
<h2>Recommendation Explanation Report</h2>

<div style="background-color: #f9f9f9; border-left: 4px solid #0d6efd; padding: 15px; margin-top: 15px;">
    <h3>Algorithm & Rule Analysis Summary</h3>
    <p>{{ $explanation ?? 'Components were selected based on your target budget, optimal performance-per-dollar ratio, and strict compatibility requirements.' }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>Decision Criteria</th>
            <th>System Strategy</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Budget Balancing</strong></td>
            <td>Allocates optimal funds towards high-impact components (GPU/CPU) while maintaining reliability in secondary parts.</td>
        </tr>
        <tr>
            <td><strong>Bottleneck Prevention</strong></td>
            <td>Ensures CPU and GPU pairings avoid severe hardware throttling under heavy loads.</td>
        </tr>
        <tr>
            <td><strong>Future Upgradeability</strong></td>
            <td>Prioritizes motherboards and power supplies with expansion headroom for future components.</td>
        </tr>
    </tbody>
</table>
@endsection