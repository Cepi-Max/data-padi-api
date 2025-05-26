<!-- Sidebar -->
    <nav class="sidebar d-flex flex-column">
        <div class="sidebar-header">
            <img src="https://img.icons8.com/ios-filled/100/ffffff/rice-plant.png" alt="Logo Data Padi">
            <h4>DATA PADI</h4>
        </div>
        <ul class="mt-4 flex-grow-1">
            <li>
                <a href="{{ route('show.dashboard') }}" class="{{ request()->routeIs('show.dashboard') ? 'active' : '' }}">
                    <i class="mr-2">&#127806;</i> Dashboard
                </a>
            </li>
            <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.' . '*') ? 'active' : '' }}"><i class="mr-2">&#128100;</i> Pengguna</a></li>
            {{-- <li><a href="#"><i class="mr-2">&#128202;</i> Statistik</a></li>
            <li><a href="#"><i class="mr-2">&#128196;</i> Data Padi</a></li>
            <li><a href="#"><i class="mr-2">&#9881;</i> Pengaturan</a></li> --}}
        </ul>
        <div class="mt-auto text-center mb-4">
            <small>&copy; 2025 Data Padi</small>
        </div>
    </nav>
   