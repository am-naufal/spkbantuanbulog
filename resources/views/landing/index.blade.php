<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Penerima Bantuan - Sistem Pendukung Keputusan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }

        .feature-card {
            transition: transform 0.3s;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #4e73df;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            padding: 10px 25px;
            border-radius: 25px;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }

        .btn-outline-light {
            border-radius: 25px;
            padding: 10px 25px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/images/slider-logo.png" alt="Logo" height="40">
                SPK Penerima Bantuan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Sistem Pendukung Keputusan Penerima Bantuan</h1>
                    <p class="lead mb-4">Sistem yang membantu dalam pengambilan keputusan untuk menentukan penerima
                        bantuan secara objektif dan transparan menggunakan metode SAW (Simple Additive Weighting).</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Utama</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <i class="fas fa-calculator feature-icon"></i>
                            <h5 class="card-title">Metode SAW</h5>
                            <p class="card-text">Menggunakan metode Simple Additive Weighting untuk perhitungan yang
                                akurat dan objektif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line feature-icon"></i>
                            <h5 class="card-title">Analisis Data</h5>
                            <p class="card-text">Visualisasi data dan analisis yang komprehensif untuk pengambilan
                                keputusan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <i class="fas fa-file-alt feature-icon"></i>
                            <h5 class="card-title">Laporan</h5>
                            <p class="card-text">Generasi laporan otomatis untuk dokumentasi dan transparansi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-4">Tentang Sistem</h2>
                    <p class="lead">Sistem Pendukung Keputusan Penerima Bantuan adalah aplikasi yang dirancang untuk
                        membantu dalam proses seleksi penerima bantuan secara objektif dan transparan.</p>
                    <p>Dengan menggunakan metode SAW (Simple Additive Weighting), sistem ini dapat membantu dalam:</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Penilaian yang objektif</li>
                        <li><i class="fas fa-check text-success me-2"></i>Perhitungan yang akurat</li>
                        <li><i class="fas fa-check text-success me-2"></i>Transparansi proses</li>
                        <li><i class="fas fa-check text-success me-2"></i>Dokumentasi yang lengkap</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <img src="/images/about-image.jpg" alt="About" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>SPK Penerima Bantuan</h5>
                    <p>Sistem Pendukung Keputusan untuk Penentuan Penerima Bantuan</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; {{ date('Y') }} SPK Penerima Bantuan. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
