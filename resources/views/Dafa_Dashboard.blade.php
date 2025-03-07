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
                <p>Nama :
                    {{old('nama_barang', $datadashboardproduklaris[0]['nama_barang'] ?? 'Belum ada Produk yang terjual Womp Womp')}}
                </p>
                <p>Total Dipesan :
                    {{old('total_kuantitas', $datadashboardproduklaris[0]['total_kuantitas'] ?? 'Belum ada Produk yang terjual Womp Womp')}}
                </p>
                <a href="{{ route('umkm.statistik') }}" class="btn btn-success">Lihat Statistik</a>
            </div>
            <div class="card">
                <h3>Ayo Kelola Pesananmu Sekarang!</h3>
                <p>Jumlah Pesanan masuk:
                    {{old('jumlah_Pesanan', $datadashboardpesananmasuk[0]['jumlah_pesanan'] ?? 'Belum ada Pesanan yang masuk Womp Womp')}}
                </p>
                <a href="{{ route('umkm.pesananditerima') }}" class="btn btn-success">Kelola Pesanan</a>
            </div>
            <div class="card">
                <h3>Mau Nambahin Produk Apa hari ini?</h3>
                <p>Produk Terakhir yang Ditambahkan :
                    {{old('nama_barang', $datadashboardprodukpalingbaru[0]['nama_barang'] ?? 'Kamu Belum Menambahkan produk')}}
                </p>
                <a href="{{ route('umkm.managebarang') }}" class="btn btn-success">Kelola Produk</a>
            </div>
            <div class="card">
                <h3>Balesin Chatmu Yuk!</h3>
                <p>Pesan Paling Baru : "
                    {{old('message', $datadashboardpesanpalingbaru[0]['message'] ?? 'Kamu belum mendapatkan message')}}"
                </p>
                <p>
                    {{old('sent_at', $datadashboardpesanpalingbaru[0]['sent_at'] ?? 'Waktu Error')}}
                </p>
                <a href="{{ route('umkm.messages.inbox') }}" class="btn btn-success">Balas Pesan</a>
            </div>
            <div class="card">
                <h3>Tambahin Campaign Supaya Jangkauan Lebih Luas!</h3>
                <p>Campain Kamu Yang paling Baru : "
                    {{old('title', $datadashboardcampaignpalingbaru[0]['title'] ?? 'Kamu belum mendapatkan message')}}"
                </p>
                <a href="{{ route('umkm.inbox') }}" class="btn btn-success">Cek Inbox</a>
            </div>
        </div>
    </div>
    </div>

    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
</body>

</html>