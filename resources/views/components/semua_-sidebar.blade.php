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
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
    <div class="sidebar">
        <h2>Seller Center</h2>
        <ul>
            <li><a href="{{ route('umkm.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('umkm.managebarang') }}">Manage Products</a></li>
            <ul>
                <li onclick="toggleSubmenu()">
                    <div class="container">
                        Pesanan
                        <img src="{{ asset('images/arrow-down-sign-to-navigate.png') }}" alt="dropdownArrow"
                            id="dropdownArrow" style="margin-left: 8px;">
                    </div>
                </li>
                <ul id="submenu" class="submenu">
                    <li><a href="{{ route('umkm.kelolapesanan') }}">Kelola Pesanan</a></li>
                    <li><a href="{{ route('umkm.pesananditerima') }}">Pesanan Diterima</a></li>
                    <li><a href="{{ route('umkm.pesananditolak') }}">Pesanan Ditolak</a></li>
                    <li><a href="{{ route('umkm.pesananselesai') }}">Pesanan Selesai</a></li>
                </ul>
            </ul>
            <li><a href="{{ route('umkm.statistik') }}">Statistik</a></li>
            <li><a href="{{ route('umkm.messages.inbox') }}">Kotak Masuk</a></li>
            <li><a href="{{ route('umkm.inbox') }}">Inbox Penjual</a></li>
            <li><a href="{{ route('umkm.masuk') }}"><img src="{{ asset('images/log-out.png') }}" alt="logout"
                        id="logout" style="margin-left: 8px; margin-right:10px;">Sign Out</a></li>
        </ul>
    </div>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
</body>

</html>