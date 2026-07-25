@extends('layouts.admin')
@section('title','Queue Management')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h4 class="mb-0">Queue Management</h4>
      <small class="text-muted">Real-time queue dashboard (demo UI • 20%)</small>
    </div>
    <div>
      <button class="btn btn-outline-secondary btn-sm">Export CSV</button>
      <button class="btn btn-primary btn-sm">Add Ticket</button>
    </div>
  </div>

  <div class="row g-3">
    <!-- Left: Live Queue -->
    <div class="col-12 col-lg-7">
      <div class="card card-shadow h-100">
        <div class="card-body">
          <h6 class="mb-3">Live Queue</h6>
          <div class="list-group" id="queueList">
            <!-- demo items -->
            <div class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">T-001 • John Dela Cruz</div>
                <div class="small text-muted">Service: Registration • Priority: Normal</div>
              </div>
              <div class="text-end">
                <span class="badge bg-warning text-dark me-2">Waiting</span>
                <button class="btn btn-sm btn-outline-primary">Call</button>
              </div>
            </div>

            <div class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">T-002 • Maria Santos</div>
                <div class="small text-muted">Service: Payment • Priority: High</div>
              </div>
              <div class="text-end">
                <span class="badge bg-info text-dark me-2">Queued</span>
                <button class="btn btn-sm btn-outline-primary">Call</button>
              </div>
            </div>

            <div class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">T-003 • Pedro Reyes</div>
                <div class="small text-muted">Service: Inquiry • Priority: Low</div>
              </div>
              <div class="text-end">
                <span class="badge bg-secondary me-2">Pending</span>
                <button class="btn btn-sm btn-outline-primary">Call</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Controls & Stats -->
    <div class="col-12 col-lg-5">
      <div class="card card-shadow mb-3">
        <div class="card-body">
          <h6 class="mb-3">Queue Controls</h6>
          <div class="mb-2">
            <label class="form-label small text-muted">Service</label>
            <select class="form-select form-select-sm">
              <option>All services</option>
              <option>Registration</option>
              <option>Payment</option>
              <option>Inquiry</option>
            </select>
          </div>
          <div class="mb-2">
            <label class="form-label small text-muted">Priority filter</label>
            <select class="form-select form-select-sm">
              <option>All</option>
              <option>High</option>
              <option>Normal</option>
              <option>Low</option>
            </select>
          </div>
          <div class="d-grid gap-2 mt-3">
            <button id="nextBtn" class="btn btn-success btn-sm">Call Next (demo)</button>
            <button id="skipBtn" class="btn btn-outline-secondary btn-sm">Skip</button>
          </div>
        </div>
      </div>

      <div class="card card-shadow">
        <div class="card-body">
          <h6 class="mb-3">Summary</h6>
          <div class="d-flex justify-content-between">
            <div class="small text-muted">Total in queue</div>
            <div class="fw-bold" id="totalQueue">3</div>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <div class="small text-muted">High priority</div>
            <div class="fw-bold text-danger" id="highCount">1</div>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <div class="small text-muted">Average wait (est.)</div>
            <div class="fw-bold" id="avgWait">8 min</div>
          </div>
          <div class="mt-3 small text-muted">This is a static demo interface for your proposal defense.</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer quick actions -->
  <div class="mt-3 d-flex justify-content-between">
    <div class="small text-muted">Demo UI only — no backend integration</div>
    <div>
      <a href="{{ route('attendance.manage') }}" class="btn btn-outline-primary btn-sm">Open Attendance</a>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<link href="{{ asset('css/queue.css') }}" rel="stylesheet">
<script src="{{ asset('js/queue-ui.js') }}" defer></script>
@endpush
