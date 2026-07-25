// queue-ui.js — demo-only interactions
document.addEventListener('DOMContentLoaded', function () {
  const nextBtn = document.getElementById('nextBtn');
  const skipBtn = document.getElementById('skipBtn');
  const totalQueue = document.getElementById('totalQueue');
  const highCount = document.getElementById('highCount');
  const avgWait = document.getElementById('avgWait');

  nextBtn?.addEventListener('click', () => {
    // purely visual demo: show a toast-like alert
    const el = document.createElement('div');
    el.className = 'alert alert-success position-fixed bottom-0 end-0 m-3';
    el.style.zIndex = 1050;
    el.innerText = 'Calling next ticket (demo): T-001';
    document.body.appendChild(el);
    setTimeout(() => el.remove(), 2500);
  });

  skipBtn?.addEventListener('click', () => {
    const el = document.createElement('div');
    el.className = 'alert alert-warning position-fixed bottom-0 end-0 m-3';
    el.style.zIndex = 1050;
    el.innerText = 'Skipped current ticket (demo)';
    document.body.appendChild(el);
    setTimeout(() => el.remove(), 2000);
  });
});
