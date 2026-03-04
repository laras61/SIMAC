<style>
    .app-nav {
        position: sticky;
        top: 0;
        z-index: 50;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }
    .app-nav-inner {
        width: min(1100px, calc(100% - 24px));
        margin: 0 auto;
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .app-brand {
        font-weight: 700;
        font-size: 16px;
        color: #0f172a;
        text-decoration: none;
    }
    .app-menu-toggle {
        display: none;
        width: 40px;
        height: 36px;
        border: 1px solid #cbd5e1;
        background: #fff;
        border-radius: 8px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .app-menu-toggle span {
        display: block;
        width: 18px;
        height: 2px;
        background: #334155;
        border-radius: 2px;
        margin: 2px 0;
    }
    .app-menu {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .app-menu a {
        text-decoration: none;
        color: #475569;
        font-size: 13px;
        padding: 7px 10px;
        border-radius: 8px;
    }
    .app-menu a:hover {
        background: #f8fafc;
    }
    .app-menu .active {
        background: #ccfbf1;
        color: #0f766e;
        font-weight: 600;
    }
    .app-menu .logout-btn {
        border: 1px solid #e2e8f0;
        color: #b91c1c;
        background: #fff;
        border-radius: 8px;
        padding: 7px 10px;
        font-size: 13px;
        cursor: pointer;
    }
    .app-menu form {
        margin: 0;
    }
    @media (max-width: 820px) {
        .app-menu-toggle {
            display: inline-flex;
            flex-direction: column;
        }
        .app-menu {
            display: none;
            position: absolute;
            top: 60px;
            left: 12px;
            right: 12px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px;
            flex-direction: column;
            align-items: stretch;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
        }
        .app-menu.open {
            display: flex;
        }
        .app-menu a,
        .app-menu .logout-btn {
            width: 100%;
            text-align: left;
        }
    }
</style>

<nav class="app-nav">
    <div class="app-nav-inner">
        <a class="app-brand" href="{{ route('dashboard') }}">SIMAC Admin</a>

        <button type="button" class="app-menu-toggle" id="appMenuToggle" aria-label="Toggle menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="app-menu" id="appMenu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">Barang</a>
            <a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.*') ? 'active' : '' }}">User</a>
            <a href="{{ route('maintenance.index') }}" class="{{ request()->routeIs('maintenance.*') ? 'active' : '' }}">Maintenance</a>
            <a href="{{ route('perbaikan.index') }}" class="{{ request()->routeIs('perbaikan.*') ? 'active' : '' }}">Perbaikan</a>
            <a href="{{ route('remainder.index') }}" class="{{ request()->routeIs('remainder.*') ? 'active' : '' }}">Reminder</a>
            <a href="{{ route('vendor.index') }}" class="{{ request()->routeIs('vendor.*') ? 'active' : '' }}">Vendor</a>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    (function () {
        const toggle = document.getElementById('appMenuToggle');
        const menu = document.getElementById('appMenu');

        if (!toggle || !menu) return;

        toggle.addEventListener('click', function () {
            const willOpen = !menu.classList.contains('open');
            menu.classList.toggle('open', willOpen);
            toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        });
    })();
</script>
