<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>
        @yield('title', 'ComputeCart Report')
    </title>

    @if(request()->query('format') === 'pdf')

        {{-- =====================================================
             PDF-ONLY STYLES
             ===================================================== --}}
        <style>

            /* =================================================
               A4 PAGE
               ================================================= */

            @page {
                size: A4 portrait;
                margin: 0;
            }

            * {
                box-sizing: border-box;
            }

            html,
            body {
                margin: 0;
                padding: 0;

                width: 100%;

                background: #ffffff;
                color: #333333;

                font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
                font-size: 10px;
            }


            /* =================================================
               PDF CONTENT AREA

               Instead of relying on @page margins, we create
               the visible white space directly here.

               Top / Bottom = 18mm
               Left / Right = 15mm
               ================================================= */

            .pdf-page {
                display: block;

                width: auto;

                margin: 18mm 15mm 18mm 15mm;
                padding: 0;
            }


            /* =================================================
               MAIN PDF HEADER
               ================================================= */

            .pdf-header {
                width: 100%;

                margin: 0 0 18px 0;
                padding: 0;

                text-align: center;
            }


            .pdf-system-title {
                margin: 0;
                padding: 0;

                font-size: 18px;
                line-height: 1.15;

                font-weight: 700;

                letter-spacing: 1.3px;

                color: #333333;

                text-transform: uppercase;
            }


            .pdf-generated {
                margin: 6px 0 0 0;
                padding: 0;

                font-size: 9px;
                line-height: 1.2;

                color: #666666;
            }


            .pdf-header-line {
                width: 100%;

                height: 0;

                margin-top: 11px;

                border-bottom: 2px solid #222222;
            }


            /* =================================================
               REPORT SECTION
               ================================================= */

            .report-section {
                width: 100%;

                margin: 0;
                padding: 0;
            }


            /* =================================================
               REPORT TITLE
               ================================================= */

            .pdf-report-title,
            .report-section > h1,
            .report-section > h2 {

                margin: 0 0 12px 0;
                padding: 0;

                font-size: 16px;
                line-height: 1.2;

                font-weight: 700;

                color: #333333;
            }


            /* =================================================
               DESCRIPTION / INFORMATION
               ================================================= */

            .report-description,
            .report-section > p {

                margin: 0 0 11px 0;
                padding: 0;

                font-size: 9px;
                line-height: 1.45;

                color: #555555;
            }


            .report-info {

                margin: 0 0 10px 0;
                padding: 0;

                font-size: 10px;
                line-height: 1.45;

                color: #333333;
            }


            /* =================================================
               REPORT TABLE CONTAINER
               ================================================= */

            .report-table-container {

                width: 100%;

                margin: 0;
                padding: 0;
            }


            /* =================================================
               TABLE
               ================================================= */

            table,
            table.report-table {

                width: 100%;

                margin: 0;
                padding: 0;

                border-collapse: collapse;
                border-spacing: 0;

                table-layout: fixed;
            }


            /* =================================================
               REPEAT TABLE HEADER ON NEW PAGES
               ================================================= */

            thead,
            table.report-table thead {

                display: table-header-group;
            }


            tbody,
            table.report-table tbody {

                display: table-row-group;
            }


            tfoot,
            table.report-table tfoot {

                display: table-row-group;
            }


            /* =================================================
               PREVENT ROW SPLITTING
               ================================================= */

            tr,
            table.report-table tr {

                page-break-inside: avoid;
            }


            /* =================================================
               TABLE HEADER
               ================================================= */

            th,
            table.report-table th {

                background: #eeeeee;

                color: #333333;

                border: 1px solid #cccccc;

                padding: 7px 9px;

                font-size: 9px;
                line-height: 1.25;

                font-weight: 700;

                text-align: left;
                vertical-align: middle;
            }


            /* =================================================
               TABLE BODY
               ================================================= */

            td,
            table.report-table td {

                background: #ffffff;

                color: #333333;

                border: 1px solid #cccccc;

                padding: 7px 9px;

                font-size: 9px;
                line-height: 1.35;

                vertical-align: middle;

                word-wrap: break-word;
                overflow-wrap: break-word;
            }


            /* =================================================
               ALTERNATING TABLE ROWS
               ================================================= */

            tbody tr:nth-child(even) td {

                background: #fafafa;
            }


            /* =================================================
               TEXT ALIGNMENT
               ================================================= */

            .text-center {

                text-align: center !important;
            }


            .text-right {

                text-align: right !important;
            }


            .text-left {

                text-align: left !important;
            }


            /* =================================================
               STATUS COLORS
               ================================================= */

            .badge-success,
            .status-success {

                color: #008000 !important;

                font-weight: 700 !important;
            }


            .badge-warning,
            .status-warning {

                color: #ff9900 !important;

                font-weight: 700 !important;
            }


            .badge-danger,
            .status-danger {

                color: #cc0000 !important;

                font-weight: 700 !important;
            }


            /* =================================================
               SUMMARY / EXPLANATION BOX
               ================================================= */

            .report-summary {

                background: #f9f9f9;

                border-left: 4px solid #333333;

                padding: 10px 12px;

                margin: 0 0 13px 0;
            }


            .report-summary-title {

                margin: 0 0 5px 0;

                font-size: 11px;

                font-weight: 700;

                color: #333333;
            }


            .report-summary p {

                margin: 0;

                font-size: 9px;

                line-height: 1.45;

                color: #444444;
            }


            /* =================================================
               TABLE FOOTER / TOTALS
               ================================================= */

            tfoot th,
            tfoot td {

                background: #eeeeee !important;

                font-weight: 700;

                border: 1px solid #cccccc;

                padding: 7px 9px;
            }


            /* =================================================
               EMPTY REPORT MESSAGE
               ================================================= */

            .report-empty {

                margin: 10px 0;

                color: #666666;

                font-size: 9px;

                font-style: italic;
            }


            /* =================================================
               REMOVE NORMAL WEBSITE ELEMENTS FROM PDF
               ================================================= */

            nav,
            header,
            footer,
            video,
            #bg-video,
            .navbar,
            .center-background,
            .no-print,
            .btn,
            button,
            .toast-container {

                display: none !important;
            }


            /* =================================================
               REMOVE BOOTSTRAP WEB WIDTHS / CARDS
               ================================================= */

            .container,
            .container-fluid,
            .card {

                width: auto !important;

                max-width: none !important;

                margin: 0 !important;

                padding: 0 !important;

                border: none !important;

                box-shadow: none !important;

                background: #ffffff !important;
            }


            /* =================================================
               LINKS
               ================================================= */

            a {

                color: inherit;

                text-decoration: none;
            }

        </style>

    @else

        {{-- =====================================================
             NORMAL WEBSITE STYLES
             ===================================================== --}}

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >

        <!-- Bootstrap 5 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
        >

        <!-- Tabler -->
        <link
            href="{{ asset('css/tabler.min.css') }}"
            rel="stylesheet"
        >

        <!-- Volt -->
        <link
            href="{{ asset('css/volt.css') }}"
            rel="stylesheet"
        >

        <!-- Font Awesome -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        >

        <!-- Configurator -->
        <link
            rel="stylesheet"
            href="{{ asset('css/configurator-ui.css') }}"
        >


        <style>

            /* =================================================
               CENTER BACKGROUND
               ================================================= */

            .center-background {

                position: fixed;

                top: 0;

                left: 50%;

                transform: translateX(-50%);

                width: 95%;

                max-width: 1400px;

                height: 100%;

                background-color: #ffffff;

                border-radius: 12px;

                z-index: -1;

                box-shadow:
                    0 8px 24px rgba(0,0,0,0.25);
            }


            /* =================================================
               BODY
               ================================================= */

            body {

                min-height: 100vh;

                font-family:
                    'Segoe UI',
                    Roboto,
                    sans-serif;

                position: relative;

                overflow-x: hidden;

                margin: 0;

                background-color: #ffffff;
            }


            /* =================================================
               BACKGROUND VIDEO
               ================================================= */

            #bg-video {

                position: fixed;

                top: 0;

                left: 0;

                width: 100%;

                height: 100%;

                object-fit: cover;

                z-index: -2;
            }


            body::after {

                content: none !important;

                background: none !important;

                animation: none !important;
            }


            /* =================================================
               NAVBAR
               ================================================= */

            .navbar {

                background-color: #111 !important;
            }


            .navbar a {

                color: #fff !important;

                font-weight: 500;

                transition:
                    color 0.3s ease,
                    text-shadow 0.3s ease;
            }


            .navbar a:hover {

                color: #fff !important;

                text-shadow:
                    0 0 8px rgba(255,255,255,0.8);
            }


            /* =================================================
               DROPDOWN
               ================================================= */

            .navbar .dropdown-menu {

                background-color: #111 !important;

                z-index: 1000;

                border-radius: 6px;

                box-shadow:
                    0 6px 18px rgba(0,0,0,0.4);
            }


            .navbar .dropdown-menu .dropdown-item {

                color: #fff;

                font-weight: 500;
            }


            /* =================================================
               FOOTER
               ================================================= */

            footer {

                background-color: #111;

                color: #ccc;

                padding: 20px 0;

                text-align: center;
            }


            /* =================================================
               REPORT TABLE
               ================================================= */

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

                border-bottom:
                    1px solid #f1f3f5;

                font-size: 0.9rem;
            }


            .table.report-table tbody tr:last-child td {

                border-bottom: none;
            }


            .table.report-table tbody tr:hover {

                background-color: #fcfdfe;
            }

        </style>

    @endif

</head>


<body
    class="{{ request()->query('format') === 'pdf'
        ? ''
        : 'd-flex flex-column min-vh-100 bg-light' }}"
>


@if(request()->query('format') === 'pdf')

    {{-- =====================================================
         PDF VERSION
         ===================================================== --}}

    <div class="pdf-page">

        <!-- ==============================================
             PDF HEADER
             ============================================== -->

        <div class="pdf-header">

            <h1 class="pdf-system-title">
                COMPUTECART AUTOMATED REPORTING SYSTEM
            </h1>


            <p class="pdf-generated">

                @yield(
                    'title',
                    'System Report'
                )

                — Generated on
                {{ now()->format('F d, Y h:i A') }}

            </p>


            <div class="pdf-header-line"></div>

        </div>


        <!-- ==============================================
             REPORT CONTENT
             ============================================== -->

        @yield('content')

    </div>


@else

    {{-- =====================================================
         NORMAL WEBSITE VERSION
         ===================================================== --}}

    <!-- Center Background -->
    <div class="center-background"></div>


    <!-- Background Video -->
    <video
        id="bg-video"
        autoplay
        muted
        loop
        class="no-print"
    >

        <source
            src="/images/BG.mp4"
            type="video/mp4"
        >

        Your browser does not support the video tag.

    </video>


    <!-- Navbar -->
    <div class="no-print">

        @include('components.navbar')

    </div>


    <!-- Report Header Action Bar -->
    <div class="container mt-4 mb-2 no-print">

        <div
            class="d-flex justify-content-between align-items-center
                   bg-white p-3 rounded shadow-sm border"
        >

            <div>

                <span
                    class="badge bg-dark text-uppercase font-monospace"
                >
                    ComputeCart Report
                </span>


                <h4
                    class="mb-0 fw-bold text-dark mt-1"
                >
                    @yield(
                        'title',
                        'System Report'
                    )
                </h4>

            </div>


            <div>

                <a
                    href="{{ request()->fullUrlWithQuery([
                        'format' => 'pdf'
                    ]) }}"
                    class="btn btn-dark btn-sm
                           d-inline-flex
                           align-items-center
                           gap-2"
                >

                    <i class="fa-solid fa-file-pdf"></i>

                    Download PDF

                </a>

            </div>

        </div>

    </div>


    <!-- Main Content -->
    <main class="flex-grow-1 py-3">

        <div class="container">

            <div
                class="card shadow-sm border-0 p-4 mb-4"
            >

                @yield('content')

            </div>

        </div>

    </main>


    <!-- Footer -->
    <div class="no-print">

        @include('components.footer')

    </div>


    <!-- Toast Notifications -->
    <div
        class="toast-container
               position-fixed
               bottom-0
               end-0
               p-3
               no-print"
    >

        @if(session('success'))

            <div
                class="toast
                       align-items-center
                       text-bg-success
                       border-0
                       show"
            >

                <div class="d-flex">

                    <div class="toast-body">
                        {{ session('success') }}
                    </div>


                    <button
                        type="button"
                        class="btn-close
                               btn-close-white
                               me-2
                               m-auto"
                        data-bs-dismiss="toast"
                    ></button>

                </div>

            </div>

        @endif


        @if(session('error'))

            <div
                class="toast
                       align-items-center
                       text-bg-danger
                       border-0
                       show"
            >

                <div class="d-flex">

                    <div class="toast-body">
                        {{ session('error') }}
                    </div>


                    <button
                        type="button"
                        class="btn-close
                               btn-close-white
                               me-2
                               m-auto"
                        data-bs-dismiss="toast"
                    ></button>

                </div>

            </div>

        @endif

    </div>


    <!-- JS Bundle -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    ></script>


    <script
        src="{{ asset('js/tabler.min.js') }}"
    ></script>


    <script
        src="{{ asset('js/volt.js') }}"
    ></script>


    <script
        src="https://cdn.jsdelivr.net/npm/chart.js"
    ></script>


    @stack('scripts')

    @yield('scripts')

@endif

</body>
</html>