<div class="header">
    <h1>Inventory Dashboard</h1>

    <p>
        Welcome, {{ session('admin_email') }} to your inventory management dashboard. Use the navigation links below to manage products, sales, and settings.
    </p>

    <div class="nav">
        <a href="{{ route('products.upload') }}">Upload Products</a>
        <a href="{{ route('products.index') }}">Products</a>
        <a href="{{ route('purchases.index') }}">Purchase</a>
        <a href="{{ route('sales.create') }}">New Sale</a>
        <a href="{{ route('sales.index') }}">Sales History</a>
        <a href="{{ route('settings.edit') }}">Settings</a>
        <a href="{{ route('reports.index') }}">Reports</a>

        <form method="POST"
              action="{{ route('logout') }}"
              class="inline">
            @csrf

            <button type="submit">
                Logout
            </button>
        </form>
    </div>
</div>