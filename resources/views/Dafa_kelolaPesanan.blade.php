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
<script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
<script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
<body>

    <x-semua_-sidebar />
    <x-profilebar :profile='$profile' />

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('umkm.kelolapesanan') }}">Pesanan
                masuk</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('umkm.pesananditerima') }}">Pesanan Diterima</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('umkm.pesananditolak') }}">Pesanan Ditolak</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('umkm.pesananselesai') }}">Pesanan Selesai</a>
        </li>
    </ul>

    <div class="content">
        <h2>Pesanan masuk</h2>
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
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="list-Pesanan">
                @if (isset($pesananmasuk) && is_array($pesananmasuk) && count($pesananmasuk) > 0)
                    @foreach ($pesananmasuk as $pesananmasuks)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pesananmasuks['id_batch']}}</td>
                            <td>{{$pesananmasuks['status_pesanan']}}</td>
                            <td>{{$pesananmasuks['nama_barang']}}</td>
                            <td>{{$pesananmasuks['kuantitas']}}</td>
                            <td>{{$pesananmasuks['total_belanja']}}</td>
                            <td>{{$pesananmasuks['alamat_pembeli']}}</td>
                            <form method="POST"
                                action="{{route('umkm.updatestatuspesananditerima', $pesananmasuks['id_batch'])}}">
                                @csrf
                                @METHOD('PUT')
                                <td><button type="submit" class="btn btn-primary">Terima</button></td>
                            </form>
                            <form method="POST"
                                action="{{route('umkm.updatestatuspesananditolak', $pesananmasuks['id_batch'])}}">
                                @csrf
                                @METHOD('PUT')
                                <td><button type="submit" class="btn btn-danger">Ditolak</button></td>
                            </form>
                        </tr>
                    @endforeach
                @else
                    <tr>

                        <td colspan="6" class="text-center">Tidak Ada Pesanan Masuk</td>
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