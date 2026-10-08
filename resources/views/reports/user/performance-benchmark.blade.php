@extends('reports.layout')

@section('content')
<h2>Performance Benchmark Report</h2>
<p>Estimated performance metrics calculated based on selected CPU, GPU, and RAM configuration.</p>

<table>
    <thead>
        <tr>
            <th>Use-Case Workload</th>
            <th>Target Resolution / Setting</th>
            <th>Estimated Score / FPS</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($scores) && is_array($scores))
            @foreach($scores as $workload => $metric)
            <tr>
                <td><strong>{{ $workload }}</strong></td>
                <td>High / Ultra Settings</td>
                <td><strong>{{ $metric }}</strong></td>
            </tr>
            @endforeach
        @else
            <tr>
                <td><strong>1080p Gaming</strong></td>
                <td>1920x1080 (High Settings)</td>
                <td><strong>120+ FPS</strong></td>
            </tr>
            <tr>
                <td><strong>1440p Gaming</strong></td>
                <td>2560x1440 (Ultra Settings)</td>
                <td><strong>85+ FPS</strong></td>
            </tr>
            <tr>
                <td><strong>3D Rendering & Editing</strong></td>
                <td>Workstation Workloads</td>
                <td><strong>High Multi-Core Efficiency</strong></td>
            </tr>
        @endif
    </tbody>
</table>
@endsection