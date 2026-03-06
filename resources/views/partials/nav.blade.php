<style>
    .app-nav {
        position: sticky;
        top: 0;
        z-index: 50;
        background: #ffffff;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        border-bottom: 1px solid #e2e8f0;
    }
    .app-nav-inner {
        width: min(1280px, calc(100% - 28px));
        margin: 0 auto;
        min-height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .app-brand {
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #0f172a;
    }
    .app-brand-badge {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #0f766e;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
        line-height: 1;
    }
    .app-brand-text {
        font-weight: 700;
        font-size: 20px;
        color: #115e59;
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
    .app-right {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
    }
    .app-menu .app-user {
        margin-left: 8px;
        padding-left: 10px;
        border-left: 1px solid #e2e8f0;
        text-align: right;
    }
    .app-menu .app-user .name {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }
    .app-menu .app-user .role {
        display: block;
        margin-top: 2px;
        font-size: 11px;
        color: #0f766e;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
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
        border: 0;
        color: #b91c1c;
        background: #fff;
        border-radius: 10px;
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .app-menu .logout-btn:hover {
        background: #fef2f2;
    }
    .app-menu .logout-btn svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .app-menu .logout-label {
        display: none;
        font-size: 13px;
        font-weight: 500;
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
        .app-menu .logout-btn {
            justify-content: flex-start;
            padding: 7px 10px;
            height: auto;
        }
        .app-menu .logout-btn svg {
            margin-right: 8px;
        }
        .app-menu .logout-label {
            display: inline;
        }
        .app-menu .app-user {
            width: 100%;
            margin-left: 0;
            padding-left: 0;
            border-left: 0;
            text-align: left;
            padding: 6px 10px 2px;
        }
    }
</style>

<nav class="app-nav">
    <div class="app-nav-inner">
        <a class="app-brand" href="{{ route('dashboard') }}">
            <span class="app-brand-badge">S</span>
            <span class="app-brand-text">SIMAC Admin</span>
        </a>

        <div class="app-right">
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
                    <div class="app-user">
                        <span class="name">{{ auth()->user()->nama }}</span>
                        <span class="role">{{ auth()->user()->role }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn" title="Logout" aria-label="Logout">
                            <svg viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                <path d="M13 20v1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h5a2 2 0 0 1 2 2v1" />
                            </svg>
                            <span class="logout-label">Logout</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    (function () {
        const toggle = document.getElementById('appMenuToggle');
        const menu = document.getElementById('appMenu');
        const logoutForms = document.querySelectorAll('form[action="{{ route('logout') }}"]');

        if (toggle && menu) {
            toggle.addEventListener('click', function () {
                const willOpen = !menu.classList.contains('open');
                menu.classList.toggle('open', willOpen);
                toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            });
        }

        logoutForms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                if (typeof Swal === 'undefined') {
                    const isConfirmed = window.confirm('Yakin mau keluar?');
                    if (isConfirmed) form.submit();
                    return;
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Keluar dari akun',
                    text: 'Yakin mau keluar?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, keluar',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#0f766e',
                    cancelButtonColor: '#0f172a'
                }).then(function (result) {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    })();
</script>
