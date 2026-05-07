{{-- resources/views/configurator.blade.php --}}
@extends('layouts.app')

@section('title', 'SmartConfigurator — ComputeCart')

@section('styles')
<style>
:root{
  --bg:#050505; --muted:#9fb0c8; --white:#ffffff;
  --accent-start:#0066ff; --accent-end:#00b4ff;
  --card-border:rgba(255,255,255,0.03); --radius:10px; --shadow:0 10px 30px rgba(0,0,0,0.7);
}
.configurator-wrap { max-width:1120px;margin:28px auto;padding:18px;font-family:Inter,Segoe UI,Roboto,Arial,sans-serif;color:var(--white);background:linear-gradient(180deg,var(--bg),#070707); }
.config-hero { background:linear-gradient(90deg,rgba(255,255,255,0.02),rgba(255,255,255,0.01));padding:18px;border-radius:12px;border:1px solid var(--card-border);box-shadow:var(--shadow);display:flex;justify-content:space-between;align-items:center;gap:12px; }
.config-hero h1{margin:0;font-size:1.6rem;font-weight:700} .config-hero p.lead{margin:6px 0 0 0;color:var(--muted)}
.card{background:linear-gradient(180deg,rgba(255,255,255,0.01),rgba(255,255,255,0.005));border-radius:12px;border:1px solid var(--card-border);padding:16px;box-shadow:var(--shadow);margin-top:16px;}
.wizard-step{padding:14px;border-radius:8px;border:1px solid rgba(255,255,255,0.02);background:rgba(255,255,255,0.01)}
.wizard-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.form-select,.form-control{background:transparent;color:var(--white);border:1px solid rgba(255,255,255,0.06);border-radius:8px;padding:8px 10px}
.progress{background:rgba(255,255,255,0.02);height:8px;border-radius:8px;overflow:hidden}
.progress-bar{background:linear-gradient(90deg,var(--accent-end),var(--accent-start));height:100%;transition:width .25s ease}
.btn-primary-glow{padding:10px 16px;border-radius:8px;border:none;color:#fff;background:linear-gradient(90deg,var(--accent-start),var(--accent-end));cursor:pointer;box-shadow:0 10px 30px rgba(0,102,255,0.12);transition:transform .16s ease;font-weight:600}
.btn-primary-glow:hover{transform:translateY(-3px);box-shadow:0 18px 40px rgba(0,102,255,0.18)}
.btn-ghost{padding:10px 14px;border-radius:8px;border:1px solid rgba(255,255,255,0.06);background:transparent;color:var(--white);cursor:pointer}
#result-components{list-style:none;padding:0;margin:0}
.cc-card{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;padding:12px;margin-bottom:12px;border-radius:10px;border:1px solid rgba(255,255,255,0.02);background:linear-gradient(180deg,rgba(255,255,255,0.01),rgba(255,255,255,0.005))}
.cc-title{font-weight:700;color:var(--white);margin-bottom:6px}
.cc-sub{color:var(--muted);font-size:0.92rem}
.cc-chips{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px}
.cc-chip{padding:6px 8px;border-radius:999px;background:rgba(255,255,255,0.02);color:var(--muted);font-size:0.82rem;border:1px solid rgba(255,255,255,0.03)}
.cc-price .price{font-weight:800;color:var(--white);font-size:1.05rem}
.small-muted{color:var(--muted)}
@media (max-width:800px){ .wizard-grid{grid-template-columns:1fr} .cc-card{flex-direction:column} }
</style>
@endsection

@section('content')
<div class="configurator-wrap">
  <div class="config-hero">
    <div>
      <h1>SmartConfigurator</h1>
      <p class="lead small-muted">Guided Build Assistant — compatibility‑checked, explainable recommendations.</p>
    </div>
    <div style="text-align:right;">
      <div class="small-muted">ComputeCart</div>
      <div style="font-weight:700;color:var(--white)">Build Assistant</div>
    </div>
  </div>

  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
      <div>
        <small class="small-muted">Step <span id="current-step">1</span> of <span id="total-steps">4</span></small>
        <div style="font-weight:600;color:var(--white);margin-top:6px;">Step <span id="current-step-label">1</span> — <span id="current-step-title">Choose Budget</span></div>
      </div>
      <div style="width:320px;">
        <div class="progress"><div id="progress-bar" class="progress-bar" style="width:25%"></div></div>
      </div>
    </div>

    <div id="wizard">
      <section class="wizard-step" data-step="1">
        <h5>Step 1 — Choose Budget</h5>
        <p class="small-muted">Pick a budget range to guide component tiers.</p>
        <div class="wizard-grid" style="margin-top:10px;">
          <div>
            <label class="small-muted">Budget Range</label>
            <select id="budget" class="form-select">
              <option value="<800">&lt; ₱40,000 (Entry)</option>
              <option value="800-1500">₱40,000 - ₱75,000 (Mid)</option>
              <option value=">1500">&gt; ₱75,000 (High)</option>
            </select>
          </div>
          <div>
            <label class="small-muted">Target Price (optional)</label>
            <input id="target-price" type="number" class="form-control" placeholder="e.g., 50000">
          </div>
          <div>
            <label class="small-muted">Why this matters</label>
            <div class="small-muted" style="padding:8px;background:rgba(255,255,255,0.01);border-radius:6px">Budget narrows component tiers and helps balance CPU/GPU choices.</div>
          </div>
          <div>
            <label class="small-muted">Quick tip</label>
            <div class="small-muted" style="padding:8px;background:rgba(255,255,255,0.01);border-radius:6px">Use target price to nudge recommendations toward a specific total.</div>
          </div>
        </div>
      </section>

      <section class="wizard-step" data-step="2" style="display:none;">
        <h5>Step 2 — Purpose & Resolution</h5>
        <p class="small-muted">Tell us what you'll use the PC for and the display target.</p>
        <div class="wizard-grid" style="margin-top:10px;">
          <div>
            <label class="small-muted">Primary Purpose</label>
            <select id="purpose" class="form-select">
              <option value="Gaming">Gaming</option>
              <option value="Office">Office / Productivity</option>
              <option value="Workstation">Workstation (Rendering, CAD)</option>
              <option value="Streaming">Streaming / Content Creation</option>
            </select>
          </div>
          <div>
            <label class="small-muted">Primary Resolution</label>
            <select id="resolution" class="form-select">
              <option value="1080p">1080p</option>
              <option value="1440p">1440p</option>
              <option value="4k">4K</option>
            </select>
          </div>
          <div style="grid-column:1 / -1">
            <label class="small-muted">Why this matters</label>
            <div class="small-muted" style="padding:8px;background:rgba(255,255,255,0.01);border-radius:6px">Purpose and resolution determine GPU tier and CPU balance.</div>
          </div>
        </div>
      </section>

      <section class="wizard-step" data-step="3" style="display:none;">
        <h5>Step 3 — Preferences</h5>
        <p class="small-muted">Optional preferences to refine the build.</p>
        <div class="wizard-grid" style="margin-top:10px;">
          <div>
            <label class="small-muted">CPU Preference</label>
            <select id="cpu_pref" class="form-select">
              <option value="">No preference</option>
              <option value="Intel">Intel</option>
              <option value="AMD">AMD</option>
            </select>
          </div>
          <div>
            <label class="small-muted">RAM Type</label>
            <select id="ram_pref" class="form-select">
              <option value="">No preference</option>
              <option value="DDR4">DDR4</option>
              <option value="DDR5">DDR5</option>
            </select>
          </div>
          <div>
            <label class="small-muted">Form Factor</label>
            <select id="form_factor" class="form-select">
              <option value="">Any</option>
              <option value="ATX">ATX</option>
              <option value="mATX">mATX</option>
              <option value="ITX">ITX</option>
            </select>
          </div>
          <div>
            <label class="small-muted">Other preferences</label>
            <div style="display:flex;gap:8px;align-items:center">
              <label style="display:flex;align-items:center;gap:8px"><input id="prefer_silent" type="checkbox" /> <span class="small-muted">Prefer quieter components</span></label>
              <label style="display:flex;align-items:center;gap:8px"><input id="prefer_budget_parts" type="checkbox" /> <span class="small-muted">Prefer cost-effective parts</span></label>
            </div>
          </div>
        </div>
      </section>

      <section class="wizard-step" data-step="4" style="display:none;">
        <h5>Step 4 — Review & Get Recommendation</h5>
        <p class="small-muted">Review your choices before requesting a recommended build.</p>
        <div id="review-summary" style="margin-top:10px;padding:12px;border-radius:8px;background:rgba(255,255,255,0.01);border:1px solid rgba(255,255,255,0.02)">
          <div><strong class="small-muted">Budget:</strong> <span id="rev-budget" class="small-muted"></span></div>
          <div><strong class="small-muted">Purpose:</strong> <span id="rev-purpose" class="small-muted"></span></div>
          <div><strong class="small-muted">Preferences:</strong> <span id="rev-prefs" class="small-muted"></span></div>
        </div>
      </section>

      <div style="display:flex;justify-content:space-between;align-items:center;margin-top:14px;">
        <button id="btn-prev" type="button" class="btn-ghost" disabled>Previous</button>
        <button id="btn-next" type="button" class="btn-primary-glow">Next</button>
      </div>
    </div>
  </div>

  <div id="result" class="card" style="display:none;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
      <div>
        <h3 style="margin:0;color:var(--white)">Recommended Build</h3>
        <p id="result-explanation" class="small-muted" style="margin:6px 0 0 0;"></p>
      </div>
      <div style="text-align:right;">
        <div class="small-muted">Estimated Total</div>
        <div id="result-price" style="font-weight:700;font-size:18px;color:var(--white)">₱0</div>
      </div>
    </div>

    <hr style="border-color:rgba(255,255,255,0.03)">

    <ul id="result-components"></ul>

    <div id="compatibility-warnings" style="display:none;margin-top:12px;">
      <div class="cc-compat">
        <strong>Compatibility Warnings</strong>
        <ul id="compat-list" style="margin-top:8px;"></ul>
      </div>
    </div>

    <div style="display:flex;gap:10px;margin-top:12px;">
      <button id="btn-add-to-cart" class="btn-primary-glow">Add Build to Cart</button>
      <button id="btn-edit-inputs" class="btn-ghost">Edit Inputs</button>
    </div>
  </div>

  <div id="messages" style="margin-top:12px;"></div>
</div>
@endsection

@section('scripts')
<script>
(function () {
  const $ = s => document.querySelector(s);
  const $$ = s => Array.from(document.querySelectorAll(s));

  document.addEventListener('DOMContentLoaded', () => {
    const steps = $$('.wizard-step');
    const totalSteps = steps.length || 4;
    let currentStep = 1;

    const progressBar = $('#progress-bar');
    const currentStepEl = $('#current-step');
    const totalStepsEl = $('#total-steps');
    const btnNext = $('#btn-next');
    const btnPrev = $('#btn-prev');
    const messages = $('#messages');

    const resultCard = $('#result');
    const resultComponents = $('#result-components');
    const resultPrice = $('#result-price');
    const resultExplanation = $('#result-explanation');
    const compatWarnings = $('#compatibility-warnings');
    const compatList = $('#compat-list');

    const btnAddToCart = $('#btn-add-to-cart');
    const btnEditInputs = $('#btn-edit-inputs');

    if (!btnNext || !btnPrev || !steps.length) {
      console.error('Wizard initialization failed: missing elements.');
      return;
    }

    if (totalStepsEl) totalStepsEl.textContent = totalSteps;
    updateProgress();

    btnNext.addEventListener('click', onNext);
    btnPrev.addEventListener('click', onPrev);
    btnAddToCart && btnAddToCart.addEventListener('click', onAddToCart);
    btnEditInputs && btnEditInputs.addEventListener('click', () => { document.getElementById('wizard').scrollIntoView({ behavior: 'smooth' }); });

    function updateProgress() {
      if (currentStepEl) currentStepEl.textContent = currentStep;
      const pct = (currentStep / totalSteps) * 100;
      if (progressBar) progressBar.style.width = pct + '%';
      steps.forEach(s => {
        const stepNum = Number(s.dataset.step || s.getAttribute('data-step') || 0);
        s.style.display = (stepNum === currentStep) ? 'block' : 'none';
      });
      btnPrev.disabled = currentStep === 1;
      btnNext.textContent = (currentStep === totalSteps) ? 'Get Recommendation' : 'Next';
      const titleMap = {1:'Choose Budget',2:'Choose Purpose',3:'Preferences',4:'Review & Get Recommendation'};
      const titleEl = document.getElementById('current-step-title');
      if (titleEl) titleEl.textContent = titleMap[currentStep] || '';
      const labelEl = document.getElementById('current-step-label');
      if (labelEl) labelEl.textContent = currentStep;
    }

    function onNext(e) {
      e && e.preventDefault();
      if (currentStep < totalSteps) {
        currentStep++;
        updateProgress();
        if (currentStep === totalSteps) populateReview();
        return;
      }
      getRecommendation();
    }

    function onPrev(e) {
      e && e.preventDefault();
      if (currentStep > 1) {
        currentStep--;
        updateProgress();
      }
    }

    function showMessage(html, type='info') {
      if (!messages) return;
      messages.innerHTML = `<div class="alert alert-${type}" role="alert">${html}</div>`;
    }
    function clearMessage(){ if (messages) messages.innerHTML = ''; }

    function populateReview() {
      $('#rev-budget') && ($('#rev-budget').textContent = $('#budget') ? $('#budget').value : '');
      $('#rev-purpose') && ($('#rev-purpose').textContent = $('#purpose') ? $('#purpose').value : '');
      const prefs = [];
      const cpuPref = $('#cpu_pref') ? $('#cpu_pref').value : '';
      const ramPref = $('#ram_pref') ? $('#ram_pref').value : '';
      const formFactor = $('#form_factor') ? $('#form_factor').value : '';
      if (cpuPref) prefs.push('CPU: ' + cpuPref);
      if (ramPref) prefs.push('RAM: ' + ramPref);
      if (formFactor) prefs.push('Form factor: ' + formFactor);
      if (!prefs.length) prefs.push('No special preferences');
      $('#rev-prefs') && ($('#rev-prefs').textContent = prefs.join(' • '));
    }

    function getRecommendation() {
      clearMessage();
      showMessage('Computing recommendation — please wait...', 'info');

      const payload = {
        budget: $('#budget') ? $('#budget').value : null,
        target_price: $('#target-price') ? $('#target-price').value || null : null,
        purpose: $('#purpose') ? $('#purpose').value : null,
        resolution: $('#resolution') ? $('#resolution').value : null,
        cpu_pref: $('#cpu_pref') ? $('#cpu_pref').value : null,
        ram_pref: $('#ram_pref') ? $('#ram_pref').value : null,
        form_factor: $('#form_factor') ? $('#form_factor').value : null,
        prefer_silent: $('#prefer_silent') ? $('#prefer_silent').checked : false,
        prefer_budget_parts: $('#prefer_budget_parts') ? $('#prefer_budget_parts').checked : false
      };

      const url = "{{ route('configurator.recommend') }}" || '/configurator/recommend';

      fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
      })
      .then(async (r) => {
        const raw = await r.text();
        let data = null;
        try { data = raw ? JSON.parse(raw) : null; }
        catch (parseErr) { console.error('Invalid JSON response', parseErr, raw); throw new Error('Invalid JSON response from server.'); }

        if (!r.ok) {
          const serverMsg = (data && (data.message || data.error)) ? (data.message || data.error) : `Server returned ${r.status}`;
          throw new Error(serverMsg);
        }
        return data;
      })
      .then(data => {
        clearMessage();
        if (!data || !Array.isArray(data.components)) {
          showMessage(data?.message || 'No recommendation returned.', 'warning');
          return;
        }
        renderRecommendation(data);
      })
      .catch(err => {
        clearMessage();
        console.error('Recommendation fetch error:', err);
        showMessage('An error occurred while computing the recommendation: ' + (err.message || 'Unknown error'), 'danger');
      });
    }

    function renderRecommendation(data) {
      resultComponents.innerHTML = '';
      let total = 0;
      (data.components || []).forEach(c => {
        const li = document.createElement('li'); li.className = 'cc-card';
        const left = document.createElement('div'); left.className = 'cc-left';
        const title = document.createElement('div'); title.className = 'cc-title'; title.textContent = `${c.category} — ${c.name}`;
        const meta = document.createElement('div'); meta.className = 'cc-sub'; meta.textContent = c.reason || '';
        const chips = document.createElement('div'); chips.className = 'cc-chips';
        (c.evidence || []).forEach(ev => {
          const chip = document.createElement('span'); chip.className = 'cc-chip'; chip.innerHTML = `<small>${ev.label}:</small> <strong>${ev.value}</strong>`; chips.appendChild(chip);
        });
        const reasonHtml = document.createElement('div'); reasonHtml.className = 'cc-reason-html'; reasonHtml.innerHTML = c.reason_html || '';
        left.appendChild(title); left.appendChild(meta); left.appendChild(chips); left.appendChild(reasonHtml);

        const right = document.createElement('div'); right.className = 'cc-price'; right.innerHTML = `<div class="price">₱${(Number(c.price || 0)).toLocaleString()}</div>`;

        li.appendChild(left); li.appendChild(right);
        resultComponents.appendChild(li);
        total += Number(c.price || 0);
      });

      resultPrice.textContent = '₱' + total.toLocaleString();
      resultExplanation.textContent = data.explanation || '';
      resultCard.style.display = 'block';

      if (data.compatibility && data.compatibility.length) {
        compatWarnings.style.display = 'block';
        compatList.innerHTML = '';
        data.compatibility.forEach(w => { const li = document.createElement('li'); li.textContent = w; compatList.appendChild(li); });
      } else {
        compatWarnings.style.display = 'none';
        compatList.innerHTML = '';
      }

      resultCard.scrollIntoView({ behavior: 'smooth' });
    }

    function onAddToCart() {
      const items = Array.from(document.querySelectorAll('#result-components li')).map(li => li.dataset.productId);
      if (!items.length) { showMessage('No components to add to cart.', 'warning'); return; }
      showMessage('Adding build to cart...', 'info');
      fetch("{{ route('configurator.addToCart') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ components: items })
      })
      .then(r => r.json())
      .then(resp => {
        clearMessage();
        if (resp.success) { showMessage('Build added to cart. Redirecting...', 'success'); setTimeout(()=>window.location.href='/cart',800); }
        else showMessage(resp.message || 'Failed to add build to cart.', 'danger');
      })
      .catch(err => { clearMessage(); console.error('Add to cart error', err); showMessage('Error adding build to cart.', 'danger'); });
    }

  });
})();
</script>
@endsection
