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

<body>
    <script>
        window.routes = {
            umkm_dashboard: "{{ route('umkm.dashboard') }}",
            umkm_managebarang: "{{ route('umkm.managebarang') }}",
            umkm_kelolapesanan: "{{ route('umkm.kelolapesanan') }}",
            umkm_pesananditerima: "{{ route('umkm.pesananditerima') }}",
            umkm_pesananditolak: "{{ route('umkm.pesananditolak') }}",
            umkm_pesananselesai: "{{ route('umkm.pesananselesai') }}",
            umkm_statistik: "{{ route('umkm.statistik') }}",
            umkm_message: "{{ route('umkm.message') }}",
            umkm_inbox: "{{ route('umkm.inbox') }}"
        };
    </script>

    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>

    <Sidebar-component></Sidebar-component>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Bar -->
        <div class="header-bar">
            <h1>Welcome to Seller Dashboard</h1>
            <div class="profile">
                <img src="{{ asset('images/Profilepic.png') }}" alt="Profile Image">
                <span>Frixky</span>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content">
            <h2>Performansi Anda</h2>

            <!-- Cards Section -->
            <div class="cards">
                <div class="card">
                    <h3>Total Penjualan</h3>
                    <p>$10,000</p>
                    <a href="#" class="btn btn-success">View Details</a>
                </div>
                <div class="card">
                    <h3>Total Orderan</h3>
                    <p>120</p>
                    <a href="#" class="btn btn-success">View Details</a>
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