<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventory Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --primary-hover: #334155;
            --accent: #3b82f6;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg: #f1f5f9;
            --card: #ffffff;
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.08);
            --glass: rgba(255,255,255,0.72);
            --glass-border: rgba(255,255,255,0.25);
            --sidebar-w: 250px;
        }
        html { min-height: 100vh; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: linear-gradient(135deg, #eef2ff 0%, #fdf2f8 50%, #f0f9ff 100%);
            background-attachment: fixed;
            color: var(--text);
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(180deg, #0a0f24 0%, #121a38 50%, #1a2548 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
            transition: transform .3s ease;
            box-shadow: 4px 0 24px rgba(0,0,0,.12);
        }
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,.06);
            background: linear-gradient(180deg, rgba(59,130,246,0.08), transparent);
        }
        .sidebar-brand h1 {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-brand h1 i {
            color: var(--accent);
        }
        .sidebar-brand small {
            font-size: 12px;
            color: rgba(255,255,255,.5);
            font-weight: 400;
            display: block;
            margin-top: 4px;
        }
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }
        .sidebar-nav .nav-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: rgba(255,255,255,.3);
            padding: 16px 12px 8px;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: rgba(255,255,255,.65);
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all .15s ease;
            margin-bottom: 2px;
            position: relative;
            border-left: 3px solid transparent;
        }
        .sidebar-nav a i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }
        .sidebar-nav a:hover {
            background: rgba(255,255,255,.08);
            color: #fff;
            border-left-color: rgba(59,130,246,0.4);
            padding-left: 11px;
        }
        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(59,130,246,0.3), rgba(99,102,241,0.2));
            color: #fff;
            border-left: 3px solid var(--accent);
            padding-left: 11px;
        }
        .sidebar-nav form button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: rgba(255,255,255,.65);
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s ease;
            font-family: inherit;
        }
        .sidebar-nav form button i {
            width: 20px;
            text-align: center;
        }
        .sidebar-nav form button:hover {
            background: rgba(255,255,255,.08);
            color: #fff;
        }
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .topbar {
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .topbar-left h2 {
            font-size: 18px;
            font-weight: 600;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
            color: var(--text-muted);
            font-size: 14px;
        }
        .topbar-right i {
            font-size: 18px;
            color: var(--text-muted);
        }
        .content-area {
            flex: 1;
            padding: 28px 32px;
        }
        .footer-bar {
            text-align: center;
            padding: 16px 32px;
            color: var(--text-muted);
            font-size: 13px;
            border-top: 1px solid var(--glass-border);
            background: rgba(255,255,255,0.5);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .card {
            background: rgba(255,255,255,0.78);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--glass-border);
            padding: 28px;
            margin-bottom: 24px;
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .card-header h2, .card-header h1 {
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-header h2 i, .card-header h1 i {
            color: var(--accent);
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s ease;
            font-family: inherit;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #fff;
            line-height: 1;
        }
        .btn:hover { background: linear-gradient(135deg, #2563eb, #4f46e5); }
        .btn-sm { padding: 7px 14px; font-size: 13px; }
        .btn-accent { background: linear-gradient(135deg, #3b82f6, #8b5cf6); }
        .btn-accent:hover { background: linear-gradient(135deg, #2563eb, #7c3aed); }
        .btn-success { background: linear-gradient(135deg, #22c55e, #14b8a6); }
        .btn-success:hover { background: linear-gradient(135deg, #16a34a, #0d9488); }
        .btn-danger { background: linear-gradient(135deg, #ef4444, #ec4899); }
        .btn-danger:hover { background: linear-gradient(135deg, #dc2626, #db2777); }
        .btn-warning { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; }
        .btn-warning:hover { background: linear-gradient(135deg, #d97706, #ea580c); color: #fff; }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-outline:hover { background: var(--bg); }
        .btn-ghost {
            background: transparent;
            color: var(--text-muted);
        }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }
        .form-input { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border); font-size: 14px; font-family: inherit; color: var(--text); background: var(--card); transition: border .15s ease; box-sizing: border-box; }
        .form-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.15), 0 0 24px rgba(59,130,246,.1); }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text); margin-bottom: 4px; }
        .form-error { font-size: 13px; color: var(--danger); margin-top: 4px; }
        .alert-success { padding: 12px 16px; border-radius: var(--radius-sm); background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534; font-size: 14px; margin-bottom: 16px; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table thead th {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border);
        }
        table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }
        table tbody tr:hover { background: #f8fafc; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-success { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534; }
        .badge-danger { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }
        .badge-warning { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
        .badge-info { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
        .badge-gray { background: linear-gradient(135deg, #f1f5f9, #e2e8f0); color: #475569; }
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        .alert-success { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534; }
        .alert-danger { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }
        .alert-info { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--glass-border);
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: transform .15s ease;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .stat-icon.blue { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1d4ed8; }
        .stat-icon.green { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a; }
        .stat-icon.amber { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706; }
        .stat-icon.red { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; }
        .stat-icon.purple { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #7c3aed; }
        .stat-icon.teal { background: linear-gradient(135deg, #ccfbf1, #99f6e4); color: #0d9488; }
        .stat-info h3 {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 4px;
        }
        .stat-info .value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
        }
        .form-group { margin-bottom: 24px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border .15s ease;
            background: #fff;
            color: var(--text);
        }
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,130,246,.15), 0 0 24px rgba(59,130,246,.1);
        }
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 80px; }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .pagination { margin-top: 20px; }
        .pagination nav span { color: var(--text-muted); }
        .search-bar {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }
        .search-bar input {
            padding: 10px 14px 10px 38px;
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            font-size: 14px;
            width: 300px;
            background: rgba(255,255,255,0.6) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E") 12px center no-repeat;
            background-size: 18px;
        }
        .search-bar input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.15), 0 0 24px rgba(59,130,246,.1); }
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-muted);
        }
        .empty-state i {
            font-size: 48px;
            color: var(--border);
            margin-bottom: 16px;
        }
        .welcome-text {
            font-size: 14px;
            color: var(--text-muted);
        }
        .welcome-text strong {
            color: var(--text);
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .content-area { padding: 20px 16px; }
            .topbar { padding: 14px 16px; }
            .search-bar input { width: 100%; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .mobile-toggle {
                display: flex !important;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                border-radius: 8px;
                border: 1px solid var(--glass-border);
                background: rgba(255,255,255,0.6);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                cursor: pointer;
                color: var(--text);
                font-size: 18px;
            }
        }
        .mobile-toggle { display: none; }
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 99;
        }
        .overlay.show { display: block; }
        @media (max-width: 768px) {
            .overlay.show { display: block; }
        }
        .inline-flex { display: inline-flex; align-items: center; gap: 6px; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .flex-wrap { flex-wrap: wrap; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 20px; }
        .w-full { width: 100%; }
    </style>
    @yield('styles')
</head>
<body>
    <div class="overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        @include('partials.header')
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h2>@yield('title', 'Dashboard')</h2>
            </div>
            <div class="topbar-right">
                <i class="fas fa-user-circle"></i>
                <span>{{ session('admin_email') ?: 'Admin' }}</span>
            </div>
        </header>

        <main class="content-area">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    @yield('scripts')

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        const sidebarLinks = document.querySelectorAll('.sidebar-nav a, .sidebar-nav form');
        const currentPath = window.location.pathname;
        sidebarLinks.forEach(link => {
            if (!link.href) return;
            const linkPath = new URL(link.href).pathname;
            if (linkPath === currentPath) {
                link.classList.add('active');
            }
            const parentSections = ['/products', '/purchases', '/sales', '/reports'];
            if (parentSections.includes(linkPath) && currentPath.startsWith(linkPath + '/') && currentPath !== linkPath + '/create') {
                link.classList.add('active');
            }
        });

        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        let touchStartX = 0;
        document.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; });
        document.addEventListener('touchend', e => {
            const diff = e.changedTouches[0].screenX - touchStartX;
            if (diff > 80 && !sidebar.classList.contains('open')) {
                sidebar.classList.add('open');
                overlay.classList.add('show');
            } else if (diff < -80 && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            }
        });

        document.querySelectorAll('.sidebar-nav a').forEach(a => {
            a.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
            });
            a.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });

        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.1)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
    </script>
</body>
</html>
