@extends('layouts.app')
@section('title','Attendance Kiosk')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10">
      <div class="card card-shadow mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="mb-0">Smart Attendance</h5>
              <small class="text-muted">Step 4 — Review & Confirm Attendance</small>
            </div>
            <div class="text-end">
              <span class="badge bg-secondary">Demo UI • 20%</span>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-12 col-md-5">
              <div class="border rounded p-3 h-100">
                <h6 class="mb-3">Review Details</h6>

                <dl class="row mb-2">
                  <dt class="col-5 text-muted">Class</dt>
                  <dd class="col-7 fw-semibold">CS101 — Computer Systems</dd>

                  <dt class="col-5 text-muted">Date</dt>
                  <dd class="col-7">2026-05-09</dd>

                  <dt class="col-5 text-muted">Time</dt>
                  <dd class="col-7">09:00 AM</dd>

                  <dt class="col-5 text-muted">Location</dt>
                  <dd class="col-7">Lab A - 2F</dd>

                  <dt class="col-5 text-muted">Mode</dt>
                  <dd class="col-7">Face Recognition (Demo)</dd>
                </dl>

                <hr>

                <h6 class="mb-2">Selected Preferences</h6>
                <ul class="list-unstyled small text-muted mb-0">
                  <li>• Contactless attendance</li>
                  <li>• Auto‑log present students</li>
                  <li>• Exportable CSV (admin)</li>
                </ul>
              </div>
            </div>

            <div class="col-12 col-md-7">
              <div class="border rounded p-3 h-100 d-flex flex-column">
                <div class="mb-3">
                  <label class="form-label small text-muted">Camera Preview</label>
                  <div class="ratio ratio-16x9 bg-dark rounded d-flex align-items-center justify-content-center text-white" id="cameraPreview">
                    <div>
                      <div class="h6">Camera preview (demo)</div>
                      <div class="small text-muted">Static placeholder for defense</div>
                    </div>
                  </div>
                </div>

                <div class="d-flex gap-2 mb-2">
                  <button id="prevBtn" class="btn btn-outline-secondary">Previous</button>
                  <button id="confirmBtn" class="btn btn-primary">Confirm Attendance</button>
                  <button id="simulateBtn" class="btn btn-light">Simulate Scan</button>
                </div>

                <div id="alertArea" class="mt-3">
                  <div id="errorBox" class="alert alert-danger d-none" role="alert">
                    <strong>An error occurred while confirming attendance:</strong> <span id="errorText">Failed to fetch.</span>
                  </div>

                  <div id="successBox" class="alert alert-success d-none" role="alert">
                    <strong>Success:</strong> Attendance confirmed for <span id="studentName">Juan Dela Cruz</span>.
                  </div>
                </div>

                <div class="mt-auto pt-3">
                  <h6 class="small text-muted mb-2">Recent scans (demo)</h6>
                  <div class="list-group list-group-flush small">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                        <div class="fw-semibold">Juan Dela Cruz</div>
                        <div class="text-muted">2026-05-09 • 09:12</div>
                      </div>
                      <span class="badge bg-success">Present</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                        <div class="fw-semibold">Maria Santos</div>
                        <div class="text-muted">—</div>
                      </div>
                      <span class="badge bg-secondary">Absent</span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <div class="small text-muted">Demo UI only — no backend integration</div>
        <div>
          <a href="{{ route('attendance.manage') }}" class="btn btn-outline-primary btn-sm">Open Management</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!-- Use asset() to avoid Mix manifest errors in demo setup -->
<link href="{{ asset('css/attendance.css') }}" rel="stylesheet">
<script src="{{ asset('js/attendance-ui.js') }}" defer></script>
@endpush
