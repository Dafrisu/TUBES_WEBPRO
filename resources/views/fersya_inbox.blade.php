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
        <div class="header-bar d-flex justify-content-between align-items-center mb-3">
            <h3>Inbox Pesanan</h3>
            <div class="d-flex">
                <div class="me-3">
                    <span class="badge bg-primary">Pesanan Masuk: {{ $jumlahPesananMasuk ?? 0}}</span>
                </div>
                <div>
                    <span class="badge bg-success">Pesanan Diterima: {{ $jumlahPesananDiterima ?? 0 }}</span>
                </div>
            </div>
        </div>


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
            <div class="row">
                @if(!empty($pesananMasuk) && count($pesananMasuk) > 0)
                @foreach($pesananMasuk as $item)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order ID: {{ $item['id_pesanan'] }}</h5>
                            <p class="card-text">
                                <strong>Nama Customer:</strong> {{ $item['nama_lengkap'] }}<br>
                                <strong>Produk:</strong> {{ $item['Nama_Barang'] }}<br>
                                <strong>Waktu:</strong> {{ date('d-m-Y H:i', strtotime($item['histori_pesanan']) ). ' WIB' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <p>Tidak ada Pesanan terbaru</p>
                @endif
            </div>
        </div>

        <div id="pesananDiterimaTable" style="display: none; margin-top: 20px;">
            <h3>Pesanan Diterima</h3>
            <div class="row">
                @if(!empty($pesananDiterima) && count($pesananDiterima) > 0)
                @foreach($pesananDiterima as $item)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order ID: {{ $item['id_pesanan'] }}</h5>
                            <p class="card-text">
                                <strong>Nama Customer:</strong> {{ $item['nama_lengkap'] }}<br>
                                <strong>Produk:</strong> {{ $item['Nama_Barang'] }}<br>
                                <strong>Waktu:</strong> {{ date('d-m-Y H:i', strtotime($item['histori_pesanan'])) . ' WIB'}}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <p>Tidak ada Pesanan terbaru</p>
                @endif
            </div>
        </div>

        <!-- tab options -->
        <div id="tabOption" style="display: none; margin-top: 20px;">
            <h3>Pengaturan Inbox</h3>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggleDashboardAlert" checked>
                <label class="form-check-label" for="toggleDashboardAlert">Tampilkan Alert di Dashboard</label>
            </div>
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