<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            :root { --primary: #0f172a; --accent: #3b82f6; --success: #22c55e; --warning: #f59e0b; --danger: #ef4444; --bg: #f1f5f9; --card: #ffffff; --text: #1e293b; --text-muted: #64748b; --border: #e2e8f0; --radius: 12px; --radius-sm: 6px; --radius-md: 10px; --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06); }
            body { font-family: 'Inter', sans-serif; }
            .btn { display: inline-flex; align-items: center; gap: 7px; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 500; border: none; cursor: pointer; text-decoration: none; transition: all .15s ease; font-family: inherit; background: var(--primary); color: #fff; line-height: 1; }
            .btn:hover { background: #1e293b; }
            .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
            .btn-outline:hover { background: var(--bg); }
            .btn-danger { background: var(--danger); }
            .btn-danger:hover { background: #dc2626; }
            .form-input { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border); font-size: 14px; font-family: inherit; color: var(--text); background: var(--card); transition: border .15s ease; box-sizing: border-box; }
            .form-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
            .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text); margin-bottom: 4px; }
            .form-error { font-size: 13px; color: var(--danger); margin-top: 4px; }
            .alert-success { padding: 12px 16px; border-radius: var(--radius-sm); background: #dcfce7; color: #166534; font-size: 14px; margin-bottom: 16px; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
