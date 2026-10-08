@extends('layouts.app')

@section('title', 'Smart PC Configurator | Next-Gen Custom PC Builder')

@push('styles')
    <style>
        /* Configurator specific custom styles */
        .font-mono {
            font-family: 'JetBrains Mono', monospace !important;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: #000000;
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Fixed Button Sizes & Position Locking */
        .btn-glow-black,
        .btn-dark,
        .btn-outline-dark,
        .fps-preset-btn,
        .btn-check + .btn-outline-dark {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-sizing: border-box;
        }

        /* Black Glow Effect on Cursor Hover & Active/Focus States */
        .btn-glow-black:hover,
        .btn-glow-black:focus,
        .btn-dark:hover,
        .btn-dark:focus,
        .btn-outline-dark:hover,
        .btn-outline-dark:focus,
        .btn-check + .btn-outline-dark:hover,
        .btn-check:checked + .btn-outline-dark,
        .fps-preset-btn:hover,
        .fps-preset-btn.active {
            box-shadow: 0 0 16px rgba(0, 0, 0, 0.8), 0 0 6px rgba(0, 0, 0, 0.9) !important;
            transform: translateY(-1px);
        }

        .btn-dark:active,
        .btn-outline-dark:active {
            transform: translateY(0);
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.5) !important;
        }

        /* Standardized Button Heights & Single-Line Formatting */
        .btn-check + .btn-outline-dark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 42px;
            min-height: 42px;
            max-height: 42px;
            font-size: 0.75rem;
            white-space: nowrap;
            padding: 0 0.25rem;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #submit-btn {
            height: 48px;
            min-height: 48px;
            white-space: nowrap;
        }

        #add-to-cart-btn {
            height: 42px;
            min-height: 42px;
            white-space: nowrap;
        }

        .fps-preset-btn {
            height: 32px;
            min-width: 65px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Table Styles for Hardware Specifications */
        .report-table-container {
            border: 1px solid #eaedf2;
            border-radius: 0.5rem;
            overflow: hidden;
            background: #fff;
        }

        .table.report-table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table.report-table th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 0.85rem 1rem;
            border-bottom: 2px solid #eaedf2;
        }

        .table.report-table td {
            padding: 1rem;
            color: #212529;
            border-bottom: 1px solid #f1f3f5;
            font-size: 0.9rem;
        }

        .table.report-table tbody tr:last-child td {
            border-bottom: none;
        }

        .table.report-table tbody tr:hover {
            background-color: #fcfdfe;
        }

        @media print {
            .no-print, header, footer, #bg-video, .center-background {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Top Toast Notification -->
    <div id="toast" class="toast-container position-fixed bottom-0 end-0 p-3 no-print" style="z-index: 2000;">
        <div id="toast-inner" class="toast align-items-center text-bg-dark border-0 hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toast-message"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        
        <!-- Header Title Banner -->
        <div class="mb-4 pb-3 border-bottom d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 text-start">
            <div class="text-start">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-dark font-mono text-uppercase tracking-widest">BUILD ENGINE</span>
                    <span class="font-mono text-muted text-uppercase" style="font-size: 11px;">• Hardware Telemetry Active</span>
                </div>
                <h1 class="h3 fw-black text-dark text-uppercase mb-1">Smart PC Configurator</h1>
                <p class="text-muted small mb-0">Guided Hardware Assistant — compatibility-checked, explainable recommendations.</p>
            </div>
            <div>
                <span class="badge bg-light text-dark border font-mono d-inline-flex align-items-center gap-2 px-3 py-2">
                    <span class="spinner-grow spinner-grow-sm text-success" role="status" style="width: 8px; height: 8px;"></span>
                    SYSTEM ONLINE
                </span>
            </div>
        </div>

        <div class="row g-4 align-items-start">
            
            <!-- LEFT PANEL: CONFIGURATOR FORM & PREFERENCES (4 cols) -->
            <div class="col-lg-4">
                <div class="card shadow-sm border p-4 rounded-4">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                        <h2 class="h6 fw-black text-uppercase text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-sliders text-xs"></i> Build Parameters
                        </h2>
                        <span class="badge bg-light text-dark font-mono text-uppercase border" style="font-size: 10px;">Parameters</span>
                    </div>

                    <form id="configurator-form" class="vstack gap-4">
                        <!-- Budget Selector -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label font-mono fw-bold text-uppercase text-secondary fs-7 mb-0">Target Budget</label>
                                <span id="budget-display" class="font-mono fs-7 fw-bold text-dark bg-light px-3 py-1 rounded border">₱65,000</span>
                            </div>
                            <input type="range" id="target_price" name="target_price" min="25000" max="150000" step="5000" value="65000" class="form-range">
                        </div>

                        <!-- Target Resolution -->
                        <div>
                            <label class="form-label font-mono fw-bold text-uppercase text-secondary fs-7 mb-2">Target Resolution</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="resolution" id="res-1080p" value="1080p" checked>
                                    <label class="btn btn-outline-dark w-100 fw-bold text-nowrap px-1" for="res-1080p">1080p</label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="resolution" id="res-1440p" value="1440p">
                                    <label class="btn btn-outline-dark w-100 fw-bold text-nowrap px-1" for="res-1440p">1440p 2K</label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="resolution" id="res-4k" value="4k">
                                    <label class="btn btn-outline-dark w-100 fw-bold text-nowrap px-1" for="res-4k">4K UHD</label>
                                </div>
                            </div>
                        </div>

                        <!-- Primary Purpose -->
                        <div>
                            <label class="form-label font-mono fw-bold text-uppercase text-secondary fs-7 mb-2">Primary Workload</label>
                            <select name="purpose" class="form-select form-select-sm py-2 fw-bold text-dark">
                                <option value="Gaming & Streaming" selected>Pure Gaming & Esports</option>
                                <option value="Content Creation & Video Editing">Video Editing & 3D Rendering</option>
                                <option value="Software Engineering & AI Workloads">Software Development & AI Workloads</option>
                            </select>
                        </div>

                        <!-- CPU Preference -->
                        <div>
                            <label class="form-label font-mono fw-bold text-uppercase text-secondary fs-7 mb-2">Processor Brand</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="cpu_pref" id="cpu-any" value="any" checked>
                                    <label class="btn btn-outline-dark w-100 fw-bold text-nowrap px-1" for="cpu-any">Any Best</label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="cpu_pref" id="cpu-amd" value="AMD">
                                    <label class="btn btn-outline-dark w-100 fw-bold text-nowrap px-1" for="cpu-amd">AMD Ryzen</label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="cpu_pref" id="cpu-intel" value="Intel">
                                    <label class="btn btn-outline-dark w-100 fw-bold text-nowrap px-1" for="cpu-intel">Intel Core</label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Factor -->
                        <div>
                            <label class="form-label font-mono fw-bold text-uppercase text-secondary fs-7 mb-2">Case Form Factor</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="form_factor" id="ff-atx" value="ATX" checked>
                                    <label class="btn btn-outline-dark w-100 fw-bold text-nowrap px-1" for="ff-atx">Mid ATX</label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="form_factor" id="ff-matx" value="mATX">
                                    <label class="btn btn-outline-dark w-100 fw-bold text-nowrap px-1" for="ff-matx">Micro-ATX</label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="form_factor" id="ff-itx" value="ITX">
                                    <label class="btn btn-outline-dark w-100 fw-bold text-nowrap px-1" for="ff-itx">Mini-ITX</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button with Glow Effect -->
                        <button type="submit" id="submit-btn" class="btn btn-dark btn-glow-black w-100 py-3 fw-bold text-uppercase tracking-wider fs-7 d-flex align-items-center justify-content-center gap-2 mt-2">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                            <span>Generate Recommended Build</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIGHT PANEL: BENCHMARKS & HARDWARE RESULTS (8 cols) -->
            <div class="col-lg-8 vstack gap-4">

                <!-- Summary Bar Card -->
                <div class="card shadow-sm border p-4 rounded-4 d-flex flex-row align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <span class="font-mono text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 10px;">Estimated System Cost</span>
                        <div class="d-flex align-items-baseline gap-3">
                            <span id="total-price-display" class="h3 fw-black font-mono text-dark mb-0">₱0.00</span>
                            <span id="compat-badge" class="badge bg-light text-dark border font-mono d-inline-flex align-items-center gap-2 text-uppercase">
                                <i class="fa-solid fa-shield-check text-success"></i> 100% Compatible
                            </span>
                        </div>
                    </div>

                    <button id="add-to-cart-btn" class="btn btn-dark btn-glow-black fw-bold py-2 px-4 text-uppercase tracking-wider fs-7 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span>Add Build to Cart</span>
                    </button>
                </div>

                <!-- Compatibility Warnings Slot -->
                <div id="warnings-container" class="d-none alert alert-warning border border-warning-subtle text-dark rounded-4 p-3">
                    <div class="d-flex align-items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-warning fs-5 mt-1"></i>
                        <div>
                            <h6 class="font-mono text-uppercase fw-bold mb-1">Compatibility Consideration</h6>
                            <ul id="warnings-list" class="small mb-0 ps-3"></ul>
                        </div>
                    </div>
                </div>

                <!-- Dynamic FPS Benchmark Dashboard -->
                <div class="card shadow-sm border p-4 rounded-4">
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between pb-3 border-bottom gap-3">
                        <div>
                            <h3 class="h6 fw-black text-uppercase text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-gauge-high text-xs"></i> FPS Performance Engine
                            </h3>
                            <p class="text-muted small mb-0 mt-1">Estimated average frame rates based on hardware synergy</p>
                        </div>

                        <!-- Graphics Quality Preset Toggles -->
                        <div class="btn-group bg-light p-1 rounded-3 border" role="group">
                            <button type="button" data-preset="low" class="fps-preset-btn btn btn-sm btn-light border-0 font-mono fw-bold text-muted">Low</button>
                            <button type="button" data-preset="med" class="fps-preset-btn btn btn-sm btn-dark font-mono fw-bold active">Medium</button>
                            <button type="button" data-preset="high" class="fps-preset-btn btn btn-sm btn-light border-0 font-mono fw-bold text-muted">Ultra</button>
                        </div>
                    </div>

                    <!-- FPS Game Bars Grid -->
                    <div id="fps-bars-grid" class="mt-4 vstack gap-3">
                        <div class="text-center py-5 text-muted font-mono small">
                            Configure parameters and click "Generate Recommended Build" to render performance metrics.
                        </div>
                    </div>
                </div>

                <!-- Recommended Components Tabular Layout -->
                <div class="card shadow-sm border p-4 rounded-4 vstack gap-3">
                    <div class="d-flex align-items-center justify-content-between pb-3 border-bottom">
                        <h3 class="h6 fw-black text-uppercase text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-microchip text-xs"></i> Selected Hardware Specification
                        </h3>
                        <span class="font-mono text-muted small fw-bold" id="item-count">0 items</span>
                    </div>

                    <div class="report-table-container">
                        <table class="table report-table">
                            <thead>
                                <tr>
                                    <th>Component / Item</th>
                                    <th>Category</th>
                                    <th class="text-center">Specs</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody id="components-list">
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted font-mono small">
                                        No build generated yet.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- AI System Explanation Card -->
                <div class="card bg-dark text-light border-0 rounded-4 p-4">
                    <div class="d-flex align-items-start gap-3">
                        <i class="fa-solid fa-circle-info text-info fs-5 mt-1"></i>
                        <p id="build-explanation" class="small mb-0 font-medium text-white-50">Configure your desired target budget and usage to view tailored hardware recommendations.</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('configurator-form');
            const targetPriceInput = document.getElementById('target_price');
            const budgetDisplay = document.getElementById('budget-display');
            const submitBtn = document.getElementById('submit-btn');
            const totalPriceDisplay = document.getElementById('total-price-display');
            const componentsList = document.getElementById('components-list');
            const fpsBarsGrid = document.getElementById('fps-bars-grid');
            const buildExplanation = document.getElementById('build-explanation');
            const warningsContainer = document.getElementById('warnings-container');
            const warningsList = document.getElementById('warnings-list');
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            const itemCount = document.getElementById('item-count');

            let currentFpsData = [];
            let activePreset = 'med';
            let currentComponents = [];

            // Safe CSRF token retriever
            const getCsrfToken = () => {
                const metaTag = document.querySelector('meta[name="csrf-token"]');
                return metaTag ? metaTag.getAttribute('content') : '{{ csrf_token() }}';
            };

            // Update range slider live display
            if (targetPriceInput && budgetDisplay) {
                targetPriceInput.addEventListener('input', (e) => {
                    budgetDisplay.textContent = '₱' + parseInt(e.target.value).toLocaleString();
                });
            }

            // FPS Preset Selector Buttons
            document.querySelectorAll('.fps-preset-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    document.querySelectorAll('.fps-preset-btn').forEach(b => {
                        b.classList.remove('btn-dark', 'active');
                        b.classList.add('btn-light', 'text-muted');
                    });
                    btn.classList.add('btn-dark', 'active');
                    btn.classList.remove('btn-light', 'text-muted');
                    activePreset = btn.dataset.preset;
                    renderFpsBars();
                });
            });

            // Submit Form via AJAX
            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Analyzing Hardware...`;
                    }

                    const formData = new FormData(form);
                    const payload = Object.fromEntries(formData.entries());

                    try {
                        const response = await fetch("{{ route('configurator.recommend') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': getCsrfToken(),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        if (!response.ok) {
                            throw new Error(`Server returned HTTP ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            currentComponents = data.components || [];
                            currentFpsData = data.fps_estimates || [];
                            
                            if (totalPriceDisplay) totalPriceDisplay.textContent = data.formatted_price || '₱0.00';
                            if (buildExplanation) buildExplanation.textContent = data.explanation || '';

                            renderComponents(currentComponents);
                            renderFpsBars();
                            handleCompatibilityWarnings(data.compatibility);
                            
                            showToast('Recommended build compiled successfully!');
                        } else {
                            showToast('Error: ' + (data.message || 'Unable to compile recommendations'), true);
                        }
                    } catch (err) {
                        console.error('Configurator Error:', err);
                        showToast('Failed to contact server. Please verify backend routes.', true);
                    } finally {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = `<i class="fa-solid fa-wand-magic-sparkles"></i> <span>Generate Recommended Build</span>`;
                        }
                    }
                });
            }

            // Render Hardware Components
            function renderComponents(components) {
                if (!componentsList) return;
                componentsList.innerHTML = '';
                if (itemCount) itemCount.textContent = `${components.length} components`;

                if (!components || components.length === 0) {
                    componentsList.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted font-mono small">
                                No hardware items returned for these parameters.
                            </td>
                        </tr>
                    `;
                    return;
                }

                components.forEach(item => {
                    const tr = document.createElement('tr');
                    const formattedPrice = '₱' + parseInt(item.price || 0).toLocaleString();

                    tr.innerHTML = `
                        <td>
                            <div class="fw-bold text-dark">${item.name}</div>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary font-mono">${item.category || 'Component'}</span>
                        </td>
                        <td class="text-secondary small text-center">
                            ${item.specs || 'N/A'}
                        </td>
                        <td class="text-end font-mono fw-bold text-dark">
                            ${formattedPrice}
                        </td>
                    `;
                    componentsList.appendChild(tr);
                });
            }

            // Render Dynamic FPS Bars
            function renderFpsBars() {
                if (!fpsBarsGrid) return;
                if (!currentFpsData || !currentFpsData.length) return;

                fpsBarsGrid.innerHTML = '';
                currentFpsData.forEach(game => {
                    let fpsValue = game.medFps || 0;
                    if (activePreset === 'low') fpsValue = game.lowFps || 0;
                    if (activePreset === 'high') fpsValue = game.highFps || 0;

                    const percentage = Math.min(Math.round((fpsValue / 300) * 100), 100);

                    const card = document.createElement('div');
                    card.className = 'vstack gap-1';
                    card.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center fs-7">
                            <span class="fw-bold text-dark d-flex align-items-center gap-2">
                                <i class="fa-solid ${game.icon || 'fa-gamepad'} text-muted"></i> ${game.name}
                            </span>
                            <span class="font-mono fw-bold text-dark">${fpsValue} <span class="text-muted" style="font-size: 10px;">FPS</span></span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-dark" role="progressbar" style="width: ${percentage}%"></div>
                        </div>
                    `;
                    fpsBarsGrid.appendChild(card);
                });
            }

            // Display Compatibility Warnings
            function handleCompatibilityWarnings(warnings) {
                if (!warningsContainer || !warningsList) return;
                
                if (warnings && warnings.length > 0) {
                    warningsList.innerHTML = warnings.map(w => `<li>${w}</li>`).join('');
                    warningsContainer.classList.remove('d-none');
                } else {
                    warningsContainer.classList.add('d-none');
                }
            }

            // Add Build to Cart AJAX
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', async () => {
                    if (!currentComponents.length) {
                        showToast('Please generate a build before adding to cart.', true);
                        return;
                    }

                    addToCartBtn.disabled = true;
                    addToCartBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Adding...`;

                    try {
                        const response = await fetch("{{ route('configurator.addToCart') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': getCsrfToken(),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ components: currentComponents })
                        });

                        const res = await response.json();
                        if (res.success) {
                            showToast(res.message || 'Build added to cart successfully!');
                        } else {
                            showToast(res.message || 'Could not add to cart.', true);
                        }
                    } catch (e) {
                        console.error('Add to Cart Error:', e);
                        showToast('Failed to add components to cart.', true);
                    } finally {
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = `<i class="fa-solid fa-cart-plus"></i> <span>Add Build to Cart</span>`;
                    }
                });
            }

            // Toast helper with fallback
            function showToast(msg, isError = false) {
                const toastEl = document.getElementById('toast-inner');
                const toastMessage = document.getElementById('toast-message');
                if (!toastEl || !toastMessage) return;

                toastMessage.textContent = msg;
                toastEl.className = isError 
                    ? 'toast align-items-center text-bg-danger border-0 show'
                    : 'toast align-items-center text-bg-dark border-0 show';

                if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
                    const bsToast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3500 });
                    bsToast.show();
                } else {
                    setTimeout(() => {
                        toastEl.classList.remove('show');
                        toastEl.classList.add('hide');
                    }, 3500);
                }
            }

            // Auto-trigger initial compile
            if (form) {
                form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
            }
        });
    </script>
@endpush