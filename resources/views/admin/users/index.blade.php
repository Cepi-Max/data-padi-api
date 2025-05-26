@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card mb-4">
        <div class="card-header" style="color:#6baf54; font-weight:600; font-size:1.2rem;">
            Manajemen Pengguna
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-padi">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Lokasi</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>
                                <img src="{{ $user->foto_profil ?? 'https://img.icons8.com/ios-glyphs/36/6baf54/user-male-circle.png' }}" 
                                     alt="Foto Profil" width="38" height="38" style="border-radius:50%;">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->lokasi ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role == 'admin' ? 'success' : ($user->role == 'petani' ? 'primary' : 'warning') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm" style="background:#6baf54; color:#fff;">
                                    Ubah Role
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
