<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKMku</title>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/fersya_inbox_2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Dafa_Dashboard.css') }}">
    <!-- Import Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- Sidebar Component -->

    <x-semua_-sidebar />
  

    <!-- Announcement Bar -->
    <!-- <div class="announcement-bar fixed-top p-3 mb-3" style="background-color: #ffb700; text-align: center;">
        <p><strong>Pengumuman :</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  
            <a href="#" class="text-dark">x</a>
        </p>
        <button class="close-btn" onclick="document.querySelector('.announcement-bar').style.display='none'" 
                style="position: fixed; top: 10px; right: 10px; background: none; border: none; font-size: 20px; cursor: pointer;">&times;
        </button>
    </div> -->

    <!-- Main Content -->
  
    <div class="col-md-10 main-content mx-auto border" style="border: 1px solid #ddd; border-radius: 10px; padding: 20px;">
        <!-- Header Bar -->
        <!-- <div class="header-bar d-flex justify-content-between align-items-center mb-3"> -->
            <!-- <h3 style="color: white;">Table Penjual</h3> -->
            <!-- <div class="profile d-flex align-items-center">
                <img src="assets/Profilepic.png" alt="Profile Image" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                <span style="color: white;"> {{old('username', $profile['username'] ?? 'error')}}</span>
            </div> -->
        <!-- </div> -->

        <!-- Navigation Tabs -->
        <!-- Navigation Tabs -->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link " href="#" onclick="showPesananMasuk()"> Masuk</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="showPesananDiterima()"> Diterima</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="showTabOptions()"> Pengaturan Inbox</a>
    </li>
</ul>
        <!-- Tab Content -->

        <!-- Table for Pesanan Masuk -->
    <div id="pesananMasukTable" style="display: block; margin-top: 20px;">
        <h3>Pesanan Masuk</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Order ID</th>
                    <th>Nama Customer</th>
                    <th>Produk</th>
                    <th>Status Pesanan</th>
                    <th>Waktu Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesananMasuk ?? [] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['id_pesanan'] }}</td>
                        <td>{{ $item['nama_lengkap'] }}</td>
                        <td>{{ $item['Nama_Barang'] }}</td>
                        <td>{{ $item['status_pesanan'] }}</td>
                        <td>{{ date('d-m-Y H:i', strtotime($item['histori_pesanan'])) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Table for Pesanan Diterima -->
    <div id="pesananDiterimaTable" style="display: none; margin-top: 20px;">
        <h3>Pesanan Diterima</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Order ID</th>
                    <th>Nama Customer</th>
                    <th>Produk</th>
                    <th>Status Pesanan</th>
                    <th>Waktu Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesananDiterima ?? [] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['id_pesanan'] }}</td>
                        <td>{{ $item['nama_lengkap'] }}</td>
                        <td>{{ $item['Nama_Barang'] }}</td>
                        <td>{{ $item['status_pesanan'] }}</td>
                        <td>{{ date('d-m-Y H:i', strtotime($item['histori_pesanan'])) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        <!-- tab options -->
        <div id="tabOption" style="display: none; margin-top: 20px;">
            <h3>Plihan Inbox</h3>
            <p>Ini adalah tab Options yang hanya berisi teks.</p>
        </div>

        <!-- Tab Settings -->
        <div class="mt-4" id="pilihTab" style="background-color: #658864; color: white; max-width: fit-content; padding: 8px;">
            <h5>Pilih Tab</h5>
        </div>

    </div>
    @include('components.idle-timeout');
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/fersya_inbox.js') }}"></script>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
</body>
</html>
