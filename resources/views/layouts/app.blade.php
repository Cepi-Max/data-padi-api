<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Padi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f5faf2;
            color: #304c2a;
        }
        .sidebar {
            height: 100vh;
            background: linear-gradient(135deg, #b1e19b 0%, #7fc77b 100%);
            color: #fff;
            min-width: 220px;
            padding: 0;
            position: fixed;
            box-shadow: 2px 0 10px rgba(144,238,144,0.15);
        }
        .sidebar .sidebar-header {
            padding: 24px 24px 12px 24px;
            background: #6baf54;
            text-align: center;
            border-radius: 0 0 20px 20px;
        }
        .sidebar .sidebar-header img {
            width: 48px;
        }
        .sidebar .sidebar-header h4 {
            margin-top: 8px;
            font-size: 1.3rem;
            letter-spacing: 1px;
            color: #fff;
        }
        .sidebar ul {
            list-style: none;
            padding: 0 12px;
            margin-top: 30px;
        }
        .sidebar ul li {
            margin-bottom: 16px;
        }
        .sidebar ul li a {
            color: #fff;
            font-weight: 500;
            font-size: 1rem;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 12px;
            display: block;
            transition: background .2s;
        }
        .sidebar ul li a.active,
        .sidebar ul li a:hover {
            background: #4c8d3d;
            color: #fff;
        }
        .main-content {
            margin-left: 230px;
            padding: 30px;
        }
        .topbar {
            background: #fff;
            border-radius: 16px;
            padding: 18px 30px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(144,238,144,0.09);
        }
        .stat-card {
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(144,238,144,0.15);
            background: #fff;
            padding: 26px;
            margin-bottom: 24px;
            text-align: center;
        }
        .stat-card h6 {
            color: #6baf54;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 7px;
        }
        .stat-card .stat {
            font-size: 2.2rem;
            font-weight: 700;
            color: #304c2a;
        }
        .table-padi th {
            color: #6baf54;
            background: #f2fbe7;
        }
        @media (max-width: 767px) {
            .sidebar {
                position: static;
                min-width: 100%;
                height: auto;
                border-radius: 0;
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            .topbar {
                padding: 12px 15px;
            }
        }

        /* Ubah warna border dan background aktif */
        .pagination .page-item.active .page-link {
            background-color: #6baf54 !important;  /* Hijau Data Padi */
            border-color: #6baf54 !important;
            color: #fff !important;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(107,175,84,0.13);
        }

        /* Warna link biasa */
        .pagination .page-link {
            color: #6baf54;
            border-radius: 8px;
            border: 1px solid #b1e19b;
            background: #f9fdf6;
            margin: 0 2px;
            transition: background 0.15s;
        }

        /* Hover efek */
        .pagination .page-link:hover {
            background: #dbe6d0;
            color: #356e35;
            border-color: #6baf54;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        @include('layouts.navbar')
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
    @stack('scripts')

</body>
</html>
