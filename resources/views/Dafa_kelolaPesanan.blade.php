<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyUMKM</title>
    <link rel="stylesheet" href="{{ asset('css/Dafa_Dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>

    <Sidebar-component></Sidebar-component>
    
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
                <a class="nav-link active" aria-current="page" href="{{ route('umkm.kelolapesanan') }}">Pesanan masuk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('umkm.pesananditerima') }}">Pesanan Diterima</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('umkm.pesananditolak') }}">Pesanan Diterima</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('umkm.pesananselesai') }}">Pesanan Diterima</a>
            </li>
        </ul>

        <div class="content">
            <h2>Pesanan masuk</h2>
        </div>
        <div class="container-fluid">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Quantitas Barang</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="list-Pesanan">
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
</body>

</html>