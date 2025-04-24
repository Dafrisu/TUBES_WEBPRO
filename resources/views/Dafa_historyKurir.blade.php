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
<x-semua_-sidebar />
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
    <div class="container">
    <h2 class="mb-4">Daftar Kurir</h2>


    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link"  href="{{ route('umkm.konfirmasiKurir') }}">Kurir ingin Daftar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('umkm.getumkmkurir') }}">Kurir aktif</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('umkm.gethistorykurirumkm') }}">History Kurir</a>
        </li>
    </ul>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Kurir</th>
                <th>Email</th>
                <th>Nomor HP</th>
            </tr>
        </thead>
        <tbody>
        @if(isset($datakurir)&& is_array($datakurir) && count($datakurir) > 0)
        @foreach($datakurir as $kurir)
        <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kurir['nama_kurir'] }}</td>
                    <td>{{ $kurir['email'] }}</td>
                    <td>{{ $kurir['nomor_telepon']}}</td>
                </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5" class="text-center">Tidak ada data kurir yang tersedia.</td>
        @endif
        </tbody>
    </table>
</div>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
</body>

</html>
