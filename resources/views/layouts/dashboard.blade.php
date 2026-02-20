<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم | أركان الأسرة')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #145b9b;
            --primary-dark: #0e4271;
            --dark: #1a1a1a;
            --white: #ffffff;
            --sidebar-width: 260px;
            --navbar-height: 65px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f4f7f9;
            color: #333;
        }

        /* ===== Top Navbar ===== */
        .dash-navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: var(--navbar-height);
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
        }

        .dash-navbar .logo-area img {
            height: 45px;
        }

        .dash-navbar .title {
            font-weight: 900;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            flex-direction: column;
            gap: 5px;
        }

        .hamburger span {
            display: block;
            width: 24px;
            height: 3px;
            background: var(--dark);
            border-radius: 2px;
            transition: 0.3s;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            right: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: var(--dark);
            overflow-y: auto;
            z-index: 1050;
            transition: 0.3s ease;
        }

        .sidebar-menu {
            list-style: none;
            padding: 15px 0;
        }

        .sidebar-menu li a,
        .sidebar-menu li button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 22px;
            color: #bdc3c7;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            background: none;
            width: 100%;
            text-align: right;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            border-right: 4px solid transparent;
            transition: all 0.3s;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li button:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--white);
        }

        .sidebar-menu li a.active {
            background: rgba(20, 91, 155, 0.1);
            color: var(--white);
            border-right-color: var(--primary);
        }

        .sidebar-menu .menu-icon {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin: 10px 20px;
        }

        .sidebar-menu li.logout-item a,
        .sidebar-menu li.logout-item button {
            color: #ff7675;
        }

        .sidebar-menu li.logout-item a:hover,
        .sidebar-menu li.logout-item button:hover {
            color: #fab1a0;
            background: rgba(255, 118, 117, 0.08);
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-right: var(--sidebar-width);
            margin-top: var(--navbar-height);
            min-height: calc(100vh - var(--navbar-height));
            padding: 30px;
        }

        /* ===== Page Header ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--dark);
        }

        /* ===== Alerts ===== */
        .alert {
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-icon {
            font-size: 1.1rem;
        }

        /* ===== Cards & Stats ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e1e8f0;
            text-align: center;
            transition: 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .stat-card h4 {
            color: #888;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: 900;
            color: var(--dark);
        }

        /* ===== Data Tables ===== */
        .data-card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid #e1e8f0;
            overflow: hidden;
        }

        .data-card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .data-card-header h2 {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--dark);
        }

        .data-card-body {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        .data-table thead th {
            background: #f8f9fb;
            padding: 14px 20px;
            text-align: right;
            font-weight: 700;
            font-size: 0.85rem;
            color: #666;
            border-bottom: 1px solid #eee;
            white-space: nowrap;
        }

        .data-table tbody td {
            padding: 14px 20px;
            border-bottom: 1px solid #f5f5f5;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: #fafbfc;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== Badges ===== */
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            display: inline-block;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fef2f2;
            color: #991b1b;
        }

        /* ===== Buttons ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-family: 'Cairo', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(20, 91, 155, 0.25);
        }

        .btn-dark {
            background: var(--dark);
            color: var(--white);
        }

        .btn-dark:hover {
            background: #333;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid #e1e8f0;
            color: #555;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 0.8rem;
        }

        .btn-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-danger:hover {
            background: #dc2626;
            color: var(--white);
        }

        .btn-edit {
            background: #f0f9ff;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .btn-edit:hover {
            background: #0369a1;
            color: var(--white);
        }

        .actions-cell {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* ===== Forms ===== */
        .form-card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid #e1e8f0;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 22px;
            text-align: right;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e1e8f0;
            border-radius: 8px;
            background: #fdfdfd;
            font-family: 'Cairo', sans-serif;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(20, 91, 155, 0.1);
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check input[type="checkbox"] {
            accent-color: var(--primary);
            width: 18px;
            height: 18px;
        }

        .form-error {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .current-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e1e8f0;
            margin-top: 8px;
        }

        /* ===== Empty State ===== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state .emoji {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        /* ===== Responsive ===== */
        @media (max-width: 992px) {
            .hamburger {
                display: flex;
            }

            .sidebar {
                right: -100%;
            }

            .sidebar.show {
                right: 0;
            }

            .main-content {
                margin-right: 0;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: var(--navbar-height);
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 1040;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @yield('styles')
    </style>
</head>

<body>

    {{-- Top Navbar --}}
    @include('components.dashboard.navbar')

    {{-- Sidebar Overlay (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    @include('components.dashboard.sidebar')

    {{-- Main Content --}}
    <main class="main-content">
        @include('components.alert')
        @yield('content')
    </main>

    <script>
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    </script>

    @yield('scripts')
</body>

</html>