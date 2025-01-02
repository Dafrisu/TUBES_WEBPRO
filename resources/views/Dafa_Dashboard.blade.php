<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyUMKM</title>
    <link rel="stylesheet" href="{{ asset('css/Dafa_Dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
<script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>

<body>

    <x-semua_-sidebar />
    <x-profilebar :profile='$profile' />


    <!-- Content Area -->
    <div class="content">
        @if (session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        <h2>Performansi Anda</h2>


        <!-- Cards Section -->
        <div class="cards">
            <div class="card">
                <h3>Produk Laris Manis!</h3>
                <p>{{old('nama_barang', $datadashboardproduklaris['nama_barang'] ?? 'Belum ada Produk yang terjual Womp Womp')}}
                </p>
                <a href="{{ route('umkm.statistik') }}" class="btn btn-success">Lihat Statistik</a>
            </div>
            <div class="card">
                <h3>Ayo Kelola Pesanan mu sekarang!</h3>
                <p>Jumlah Pesanan masuk:
                    {{old('jumlah_Pesanan', $datadashboardpesananmasuk['nama_barang'] ?? 'Belum ada Pesanan yang masuk Womp Womp')}}
                </p>
                <a href="{{ route('umkm.pesananditerima') }}" class="btn btn-success">Kelola Pesanan</a>
            </div>
            <div class="card">
                <h3>Produk Terjual</h3>
                <p>80</p>
                <a href="#" class="btn btn-success">View Details</a>
            </div>
        </div>
    </div>
    </div>

    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
</body>

</html>