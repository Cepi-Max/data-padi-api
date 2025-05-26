<!-- Navbar -->
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp
<div class="topbar d-flex justify-content-between align-items-center">
    <span style="font-size:1.2rem;font-weight:600;letter-spacing:1px;color:#6baf54;">
        Selamat Datang, {{ $user ? $user->name : 'Admin' }}!
    </span>
    <div class="d-flex align-items-center gap-3">
      <img src="https://img.icons8.com/ios-glyphs/36/6baf54/user-male-circle.png" alt="Admin" style="vertical-align:middle;">
      <span style="font-size:1rem; color:#4c8d3d; margin-right:12px;">
        {{ $user ? $user->email : '-' }}
      </span>
      <form action="{{ route('logout') }}" method="GET" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-sm" style="background:#e1f5e5; color:#4c8d3d; border-radius:18px; font-weight:500; box-shadow:0 1px 4px rgba(107,175,84,0.12); transition:background .2s;">
              Logout
          </button>
      </form>
    </div>
</div>

