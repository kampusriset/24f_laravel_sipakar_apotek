<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir Apotek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Apotek System</a>
            <div class="d-flex align-items-center text-white">
                <span class="me-3">Halo, {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})</span>
                @if(Auth::user()->role === 'admin')
                    <a href="/admin" class="btn btn-warning btn-sm me-2">Panel Admin</a>
                @endif
                
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="mb-4">Menu Utama Kasir</h2>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <h3 class="card-title text-primary fw-bold">🛒 Kasir / POS</h3>
                        <p class="card-text text-muted">Akses sistem kasir dan transaksi penjualan obat secara cepat.</p>
                        <a href="{{ route('kasir.pos') }}" class="btn btn-primary btn-lg w-100 mt-3">Buka Kasir POS</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <h3 class="card-title text-success fw-bold">📋 Rekam Medis Pasien</h3>
                        <p class="card-text text-muted">Input data pasien baru, riwayat penyakit, dan pengecekan keamanan obat.</p>
                        <a href="{{ route('kasir.rekam_medis') }}" class="btn btn-success btn-lg w-100 mt-3">Buka Rekam Medis</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>