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
<script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
<script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
<body>


    <x-semua_-sidebar />
    <x-profilebar :profile='$profile' />

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
        <h2>Pesanan Ditolak</h2>
    </div>
    <div class="container">
        <div class="table-responsive">
        <table class="table-hover">
            <thead>
                <tr>
                    <th scope="col" style="width: 80px">NO</th>
                    <th scope="col">ID Pesanan</th>
                    <th scope="col">Status Pesanan</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Kuantitas Barang</th>
                    <th scope="col">Total Belanja</th>
                    <th scope="col">Alamat Pembeli</th>
                </tr>
            </thead>
            <tbody id="list-Pesanan">
                @if (isset($pesananditolak) && is_array($pesananditolak) && count($pesananditolak) > 0)
                    @foreach ($pesananditolak as $pesananditolaks)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pesananditolaks['id_batch']}}</td>
                            <td>{{$pesananditolaks['status_pesanan']}}</td>
                            <td>{{$pesananditolaks['nama_barang']}}</td>
                            <td>{{$pesananditolaks['kuantitas']}}</td>
                            <td>{{$pesananditolaks['total_belanja']}}</td>
                            <td>{{$pesananditolaks['alamat_pembeli']}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>

                        <td colspan="6" class="text-center">Tidak Ada Pesanan Yang Ditolak</td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>
    </div>
    </div>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
</body>

</html>