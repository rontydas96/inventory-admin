<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'Inventory Dashboard')</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            padding: 30px;
            margin: 0;
        }

        .container {
            max-width: 1300px;
            margin: auto;
        }

        .header {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
            margin-bottom: 25px;
        }

        .nav {
            margin-top: 15px;
        }

        .nav a,
        .nav button {
            display: inline-block;
            margin: 6px 8px 6px 0;
            padding: 10px 16px;
            background: #0f172a;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #64748b;
        }
    </style>

    @yield('styles')

    
</head>

<body>

    <div class="container">

        @include('partials.header')

        @yield('content')

        @include('partials.footer')

    </div>

</body>

</html>