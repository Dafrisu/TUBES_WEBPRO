<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Conect CSS bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/haikal_manage.css') }}">
    <title>Manage Barang</title>
    <style>
        /* Main content area styling */
        body {
            margin: 0;
        }


        .btn:hover {
            background-color: #3e583d;
        }

        #id_manage {
            background-color: grey;
            opacity: 50%;
        }

        #tambahbarang a button {
            text-decoration: none;
            color: white;
            background-color: #658864;
        }



        /* not used, but just leave it there, just in case
        table{
            margin-top: 3px;
        }
        table tr th{
            border: solid black;
        }
        table tbody tr td{
            border: solid;
        }
            */
    </style>
</head>

<body>
    <!-- Sidebar -->
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
            umkm_inbox: "{{ route('umkm.inbox') }}",
        };
    </script>


    <x-semua_-sidebar />



    <!-- yang membungkus -->
    <div class="container-sm w-75 ms-4 me-4 mt-4">
        <div class="d-flex align-items-center">
            <div class="fs-3 align-bottom">Kelola Produk</div>
            <div class="ms-auto" id="tambahbarang"><a href="{{ route('umkm.tambahbarang') }}"><button
                        class="btn ms-auto addproduk">tambah</button></a></div>
        </div>

        <!-- container dan opsi -->
        <div class="container mt-3">
            @if (session('success'))
            <div class="alert alert-success" , role="alert">
                {{session('success')}}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
            @endif
            <div class="row d-flex">
                <div class="col-auto">
                    <ul class="nav nav-underline d-flex overflow-auto" style="white-space: nowrap;">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" id="brg-semua">Semua</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="brg-habis">Stok Habis</a>
                        </li>

                    </ul>
                </div>
                <div class="col-auto ms-auto">
                    <button id="refreshbutton" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Tables -->
        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">ID Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Berat</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="produktable">
                <!-- isi tabel dari json dan js -->
                @if (isset($produk) && is_array($produk) && count($produk) > 0)
                @foreach ($produk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['nama_barang'] }}</td>
                    <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>{{ $item['stok'] }}</td>
                    <td>{{ $item['berat'] }} kg</td>
                    <td>
                        <a href="{{route('umkm.viewupdate', $item['id'])}}"><button type="button"
                                class="btn btn-warning">Edit</button></a>
                        <form action="{{route('umkm.deletebarang', $item['id'])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>

                    <td colspan="6" class="text-center">Data produk tidak tersedia.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Script buat pills -->
    <!-- <script src="{{ asset('js/Haikal_managebarang.js') }}"></script> -->
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>

</body>

</html>