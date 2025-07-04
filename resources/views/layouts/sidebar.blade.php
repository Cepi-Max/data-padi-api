<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<nav class="sidebar d-flex flex-column text-white shadow-lg px-3 pt-4"
    style="min-height: 100vh; width: 260px; position: fixed; z-index: 100; background: linear-gradient(180deg, #1e3c1e, #142814, #0a1a0a);">

    <div class="sidebar-header d-flex flex-column align-items-center mb-4">
        <div class="logo-circle mb-2">
            <i class="fas fa-seedling fa-2x" style="color: #6baf54;"></i>
        </div>
        <h4 class="fw-bold mb-0 text-white">DATA PADI</h4>
        <small class="text-muted">Manajemen Pertanian</small>
    </div>

    <ul class="nav flex-column mt-3 flex-grow-1">
        <li class="nav-item mb-2">
            <a href="{{ route('show.dashboard') }}"
                class="nav-link d-flex align-items-center sidebar-link {{ request()->routeIs('show.dashboard') ? 'active' : '' }}">
                <i class="me-3 fs-5 fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.users.index') }}"
                class="nav-link d-flex align-items-center sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="me-3 fs-5 fas fa-users"></i>
                <span>Pengguna</span>
            </a>
        </li>
    </ul>

    <div class="text-center mt-auto pt-4 border-top border-secondary text-light">
        <small class="d-block text-muted">Versi 1.0</small>
        <small class="text-muted">&copy; {{ date('Y') }} Data Padi</small>
    </div>
</nav>

<style>
    .logo-circle {
        width: 60px;
        height: 60px;
        /* Menggunakan overlay hijau lembut */
        background-color: rgba(107, 175, 84, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease-in-out;
    }

    .logo-circle:hover {
        background-color: rgba(107, 175, 84, 0.15);
        transform: rotate(5deg);
    }

    .sidebar-link {
        color: #ffffff;
        padding: 12px 18px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
    }

    .sidebar-link:hover {
        /* Overlay putih yang lembut, cocok dengan background gelap apapun */
        background-color: rgba(255, 255, 255, 0.08);
        transform: translateX(6px);
    }

    .sidebar-link.active {
        background-color: rgba(255, 255, 255, 0.1);
        font-weight: bold;
        /* Border kiri diubah menjadi warna hijau utama */
        border-left: 4px solid #6baf54;
    }

    .sidebar-header h4 {
        font-size: 1.4rem;
    }

    .sidebar-header small {
        font-size: 0.85rem;
        color: #aaaaaa;
    }
</style>    