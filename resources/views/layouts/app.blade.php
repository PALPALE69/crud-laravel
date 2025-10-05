<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Aplikasi CRUD')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f7cac9 0%, #92a8d1 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            color: #222;
        }
        .navbar {
            background: #f7786b !important;
            border-bottom: 4px solid #355c7d;
            box-shadow: 0 4px 16px rgba(53,92,125,0.1);
        }
        .navbar-brand {
            font-family: 'Press Start 2P', cursive;
            color: #fff !important;
            letter-spacing: 2px;
            font-size: 1.3rem;
            text-shadow: 2px 2px 0 #355c7d;
        }
        .retro-card {
            background: #fffbe7;
            border: 2px solid #f7cac9;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(53,92,125,0.12);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        h1, h2, h3 {
            font-family: 'Press Start 2P', cursive;
            color: #355c7d;
            text-shadow: 1px 1px 0 #f7cac9;
        }
        .btn-primary, .btn-success, .btn-warning, .btn-danger {
            border-radius: 8px;
            font-family: 'Montserrat', Arial, sans-serif;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .table {
            background: #fffbe7;
            border-radius: 12px;
            overflow: hidden;
        }
        .table th {
            background: #f7786b;
            color: #fff;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.9rem;
        }
        .table td {
            font-family: 'Montserrat', Arial, sans-serif;
        }
        .input-group .form-control {
            border-radius: 8px 0 0 8px;
        }
        .input-group .btn {
            border-radius: 0 8px 8px 0;
        }
        .retro-footer {
            background: #355c7d;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            margin-top: 2rem;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/dosen') }}">Dosen</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/mahasiswa') }}">Mahasiswa</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/mata_kuliah') }}">Mata Kuliah</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="container">
            <div class="retro-card">
                @yield('content')
            </div>
        </div>
    </main>
    <div class="retro-footer">
        &copy; {{ date('Y') }} CRUD by PALPALE69
    </div>
</body>
</html>
