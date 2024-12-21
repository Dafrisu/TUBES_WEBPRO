<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyUMKM</title>
    <link rel="stylesheet" href="css/Dafa_Dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<body>

    <div class="sidebar">
        <h2>Seller Center</h2>
        <ul>
            <li><a href="Dafa_Dashboard.html">Dashboard</a></li>
            <li><a href="Haikal_ManageBarang.html">Manage Products</a></li>
            <ul>
                <li onclick="toggleSubmenu()">
                    <div class="container">
                        Pesanan
                        <img src="assets/arrow-down-sign-to-navigate.png" alt="dropdownArrow" id="dropdownArrow"
                            style="margin-left: 8px;">
                    </div>
                </li>
                <ul id="submenu" class="submenu">
                    <li><a href="Dafa_kelolaPesanan.html">Kelola Pesanan</a></li>
                    <li><a href="Dafa_pesananDiterima.html">Pesanan Diterima</a></li>
                    <li><a href="Dafa_pesananDitolak.html">Pesanan Ditolak</a></li>
                    <li><a href="Dafa_pesananSelesai.html">Pesanan Selesai</a></li>
                </ul>
            </ul>
            <li><a href="Mahesa_Statistik_Penjualan.html">Statistics</a></li>
            <li><a href="Raphael_message_penjual.html">Kotak Masuk</a></li>
            <li><a href="fersya_inbox.html">Inbox Penjual</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Bar -->
        <div class="header-bar">
            <h1>Kelola Pesanan</h1>
            <div class="profile">
                <img src="assets/Profilepic.png" alt="Profile Image">
                <span>Frixky</span>
            </div>
        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="Dafa_kelolaPesanan.html">Pesanan masuk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="Dafa_pesananDiterima.html">Pesanan Diterima</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Dafa_pesananDitolak.html">Pesanan Ditolak</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Dafa_pesananSelesai.html">Pesanan Selesai</a>
            </li>
        </ul>

        <div class="content">
            <h2>Pesanan Ditolak</h2>
        </div>
        <div class="container-fluid">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Quantitas Barang</th>
                        <th scope="col">Harga</th>
                    </tr>
                </thead>
                <tbody id="list-Pesanan">
                    <td>1</td>
                    <td>Logitech G502 HERO High Performance Gaming Mouse</td>
                    <td>1</td>
                    <td>RP.500.000</td>
                </tbody>
            </table>
        </div>
    </div>
    <script src="javascript/Dafa_Dashboard.js"></script>
</body>

</html>