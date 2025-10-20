<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f9f5f0; /* coklat muda lembut */
            color: #3e2723; /* coklat tua */
        }
        nav.navbar {
            background-color: #6d4c41; /* coklat medium */
        }
        nav.navbar a.nav-link, nav.navbar .navbar-brand {
            color: #fff !important;
            font-weight: 500;
        }
        nav.navbar a.nav-link:hover {
            color: #ffe0b2 !important; /* efek hover krem */
        }
        .btn-primary {
            background-color: #795548;
            border-color: #6d4c41;
        }
        .btn-primary:hover {
            background-color: #5d4037;
        }
        .btn-success {
            background-color: #8d6e63;
            border-color: #6d4c41;
        }
        .btn-success:hover {
            background-color: #6d4c41;
        }
        .btn-secondary {
            background-color: #bcaaa4;
            border-color: #8d6e63;
            color: #3e2723;
        }
        .btn-secondary:hover {
            background-color: #a1887f;
            color: white;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/mahasiswa') }}">Kampus Laravel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/mahasiswa') }}">Daftar</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/mahasiswa/create') }}">Tambah</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten Dinamis --}}
    <main>
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
