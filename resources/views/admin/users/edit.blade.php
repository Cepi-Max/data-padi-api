@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-3">
                <div class="card-header" style="color:#6baf54; font-weight:600; font-size:1.1rem;">
                    Ubah Role Pengguna
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        <div class="mb-3 text-center">
                            <img src="{{ $user->foto_profil ?? 'https://img.icons8.com/ios-glyphs/48/6baf54/user-male-circle.png' }}" 
                                 alt="Foto Profil" width="56" height="56" style="border-radius:50%;">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Simpan Perubahan</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
