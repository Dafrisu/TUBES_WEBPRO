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
        <h2>UMKM Center</h2>
        <ul>
            <li><a href="{{ route('umkm.dashboard') }}"><img src="/images/dashboard.png" alt=""
                        id="icondashboard" style="margin-left: 8px; margin-right:10px;">Dasbor</a></li>
            <li><a href="{{ route('umkm.managebarang') }}"><img src="/images/products.png" alt=""
                        id="iconproducts" style="margin-left: 8px; margin-right:10px;">Kelola Produk</a></li>
            <li onclick="toggleSubmenu()" style="margin-left: 8px;">
                <div class="container"><img src="{{ asset('images/pesanan.png') }}" alt=""
                        id="iconpesanan">
                    Pesanan
                    <img src="{{ asset('images/arrow-down-sign-to-navigate.png') }}"
                        alt="dropdownArrow" id="dropdownArrow" style="margin-left: 8px; margin-right:10px;">
                </div>
            </li>
            <ul id="submenu" class="submenu">
                <li><a href="{{ route('umkm.kelolapesanan') }}">Pesanan masuk</a></li>
                <li><a href="{{ route('umkm.pesananditerima') }}">Pesanan Diterima</a></li>
                <li><a href="{{ route('umkm.pesananditolak') }}">Pesanan Ditolak</a></li>
                <li><a href="{{ route('umkm.pesananselesai') }}">Pesanan Selesai</a></li>
            </ul>
            <li><a href="{{ route('umkm.statistik') }}"><img
                        src="{{ asset('images/statistic.png') }}" alt="" id="iconstatistik"
                        style="margin-left: 8px; margin-right:10px;">Statistik</a></li>
            <li><a href="{{ route('umkm.messages.inbox') }}"><img
                        src="{{ asset('images/message.png') }}" alt="" id="iconkotakmasuk"
                        style="margin-left: 8px; margin-right:10px;">Kotak Masuk</a></li>
            <li><a href="{{ route('umkm.inbox') }}"><img
                        src="{{ asset('images/inbox.png') }}" alt="" id="iconinboxpenjual"
                        style="margin-left: 8px; margin-right:10px;">Inbox Penjual</a>
            </li>
            <li><a href="{{ route('umkm.konfirmasiKurir') }}"><img
                        src="{{ asset('images/motorbike.png') }}" alt="" id="kelolaKurir"
                        style="margin-left: 8px; margin-right:10px;">Kelola Kurir</a></li>

            <li><a href="{{ route('umkm.masuk') }}"><img
                        src="{{ asset('images/log-out.png') }}" alt="logout" id="logout"
                        style="margin-left: 8px; margin-right:10px;">Keluar</a></li>
        </ul>
    </div>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
</body>

</html>
