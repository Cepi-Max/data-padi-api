<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <title>Login - Data Padi</title>
    <style>
        body {
            background: linear-gradient(135deg, #dbe6d0 0%, #b1e19b 100%);
            min-height: 100vh;
        }
        .card {
            border-radius: 1.5rem;
            box-shadow: 0 4px 20px rgba(144, 238, 144, 0.3);
        }
        .logo-padi {
            width: 65px;
            margin-bottom: 16px;
        }
        .btn-padi {
            background-color: #6baf54;
            border: none;
        }
        .btn-padi:hover {
            background-color: #4c8d3d;
        }
        .bg-padi {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 160px;
            opacity: 0.16;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <section class="vh-100 d-flex align-items-center" style="position: relative;">
        <img src="https://img.icons8.com/ios-filled/100/6baf54/rice-plant.png" alt="Padi" class="bg-padi">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card p-4 shadow-2-strong">
                        <div class="card-body">
                            <div class="text-center">
                                <!-- Ganti link gambar logo sesuai kebutuhan -->
                                <img src="https://img.icons8.com/ios-filled/100/6baf54/rice-plant.png" class="logo-padi" alt="Logo Data Padi">
                                {{-- <h4 class="mb-2" style="color: #6baf54;">DATA PADI</h4> --}}
                                {{-- <p class="mb-4 text-muted">Login untuk mengakses data padi</p> --}}
                            </div>
                            <h5 class="mb-4 text-center font-weight-bold" style="color:#4c8d3d;">Silahkan Login</h5>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="email" style="color:#4c8d3d;">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email">
                                </div>
                                <div class="form-group">
                                    <label for="password" style="color:#4c8d3d;">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                                </div>
                                <div class="mb-3">
                                    <span>Belum Terdaftar?</span> <a href="{{ route('register.show') }}" style="color:#6baf54;">Daftar</a>
                                </div>
                                <button type="submit" class="btn btn-padi btn-block text-white">Masuk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
