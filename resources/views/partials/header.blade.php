<div class="sidebar-brand">
    <h1><i class="fas fa-cubes"></i> Inventory</h1>
    <small>Management Dashboard</small>
</div>

<nav class="sidebar-nav">
    <div class="nav-label">Main Menu</div>

    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="fas fa-box"></i> Products
    </a>
    <a href="{{ route('products.create') }}" class="{{ request()->routeIs('products.create') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Add Product
    </a>
    <a href="{{ route('products.upload') }}" class="{{ request()->routeIs('products.upload') ? 'active' : '' }}">
        <i class="fas fa-upload"></i> Upload Excel
    </a>

    <div class="nav-label">Transactions</div>

    <a href="{{ route('purchases.index') }}" class="{{ request()->routeIs('purchases.*') ? 'active' : '' }}">
        <i class="fas fa-truck-loading"></i> Purchases
    </a>
    <a href="{{ route('purchases.create') }}" class="{{ request()->routeIs('purchases.create') ? 'active' : '' }}">
        <i class="fas fa-cart-plus"></i> New Purchase
    </a>
    <a href="{{ route('sales.create') }}" class="{{ request()->routeIs('sales.create') ? 'active' : '' }}">
        <i class="fas fa-shopping-cart"></i> New Sale
    </a>
    <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.*') && !request()->routeIs('sales.create') ? 'active' : '' }}">
        <i class="fas fa-receipt"></i> Sales History
    </a>

    <div class="nav-label">Reports & Settings</div>

    <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
        <i class="fas fa-chart-bar"></i> Reports
    </a>
    <a href="{{ route('settings.edit') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
        <i class="fas fa-cog"></i> Settings
    </a>

    <div class="nav-label" style="border-top:1px solid rgba(255,255,255,.08); padding-top:16px; margin-top:8px;">Account</div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</nav>
