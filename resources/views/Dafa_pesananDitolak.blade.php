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
    <x-semua_-sidebar />
    <x-profilebar />

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href={{route('umkm.kelolapesanan')}}>Pesanan masuk</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href={{route('umkm.pesananditerima')}}>Pesanan
                Diterima</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href={{route('umkm.pesananditolak')}}>Pesanan Ditolak</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href={{route('umkm.pesananselesai')}}>Pesanan Selesai</a>
        </li>
    </ul>

    <div class="content">
        <h2>Pesanan Diterima</h2>
    </div>
    <div class="container-fluid">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">ID Pesanan</th>
                    <th scope="col">Status Pesanan</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Kuantitas Barang</th>
                    <th scope="col">Total Belanja</th>
                    <th scope="col">Alamat Pembeli</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="list-Pesanan">
                @foreach ($pesananditolak as $pesananditolaks)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$pesananditolaks['id_pesanan']}}</td>
                        <td>{{$pesananditolaks['status_pesanan']}}</td>
                        <td>{{$pesananditolaks['nama_barang']}}</td>
                        <td>{{$pesananditolaks['kuantitas_barang']}}</td>
                        <td>{{$pesananditolaks['total_belanja']}}</td>
                        <td>{{$pesananditolaks['alamat_pembeli']}}</td>
                        <td>NULL</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
</body>

</html>