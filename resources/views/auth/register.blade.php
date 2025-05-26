<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <title>Register - Data Padi</title>
    <style>
        body {
            background: linear-gradient(135deg, #dbe6d0 0%, #b1e19b 100%);
            min-height: 100vh;
        }
        .card {
            border-radius: 1.5rem;
            box-shadow: 0 4px 20px rgba(144, 238, 144, 0.25);
        }
        .logo-padi {
            width: 60px;
            margin-bottom: 12px;
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
        .card-header {
            background-color: #f6fff2;
            border-radius: 1.5rem 1.5rem 0 0;
            text-align: center;
            color: #6baf54;
            font-size: 1.4rem;
            font-weight: bold;
            border-bottom: none;
        }
        .form-label {
            color: #4c8d3d;
        }
        .login-link {
            color: #6baf54;
        }
        .login-link:hover {
            color: #4c8d3d;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <section class="vh-100 d-flex align-items-center" style="position:relative;">
        <img src="https://img.icons8.com/ios-filled/100/6baf54/rice-plant.png" alt="Padi" class="bg-padi">
        <div class="container py-5 h-100">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong p-3">
                        <div class="card-header">
                            <img src="https://img.icons8.com/ios-filled/100/6baf54/rice-plant.png" class="logo-padi" alt="Logo Data Padi"><br>
                            DAFTAR AKUN
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <span style="color:#4c8d3d;font-weight:500;">Silakan daftar untuk mengakses data padi</span>
                            </div>
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
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>

                                <div class="mb-3 mt-4">
                                    <span>Sudah punya akun?</span>
                                    <a href="{{ route('login') }}" class="login-link">Login</a>
                                </div>
                                <button type="submit" class="btn btn-padi btn-block text-white">Daftar</button>
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
