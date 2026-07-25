// Demo-only UI interactions for the attendance kiosk page
document.addEventListener('DOMContentLoaded', function () {
  const errorBox = document.getElementById('errorBox');
  const successBox = document.getElementById('successBox');
  const errorText = document.getElementById('errorText');
  const studentName = document.getElementById('studentName');

  const simulateBtn = document.getElementById('simulateBtn');
  const confirmBtn = document.getElementById('confirmBtn');
  const prevBtn = document.getElementById('prevBtn');

  function hideAlerts() {
    errorBox.classList.add('d-none');
    successBox.classList.add('d-none');
  }

  simulateBtn?.addEventListener('click', () => {
    hideAlerts();
    // simulate a random outcome
    const ok = Math.random() > 0.2;
    if (ok) {
      studentName.innerText = 'Juan Dela Cruz';
      successBox.classList.remove('d-none');
    } else {
      errorText.innerText = 'No face detected (demo)';
      errorBox.classList.remove('d-none');
    }
  });

  confirmBtn?.addEventListener('click', () => {
    hideAlerts();
    // show success placeholder
    studentName.innerText = 'Juan Dela Cruz';
    successBox.classList.remove('d-none');
  });

  prevBtn?.addEventListener('click', () => {
    // navigate back in UI flow (demo)
    window.history.back();
  });
});
