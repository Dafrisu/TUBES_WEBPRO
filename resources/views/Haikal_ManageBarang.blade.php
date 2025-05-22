<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Conect CSS bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

        #buka {
            height: 1rem;
        }

        #modalproduk span {
            color: black;
            /* Warna teks hitam */
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
    <x-modal-produk />



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
                    <ul class="nav nav-underline d-flex overflow-auto" style="white-space: nowrap;" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#semua" role="tab" id="brg-semua-tab" aria-controls="semua" aria-selected="true">
                                Semua
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#makanan" role="tab" id="brg-makanan-tab" aria-controls="makanan" aria-selected="false">
                                Makanan
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#minuman" role="tab" id="brg-minuman-tab" aria-controls="minuman" aria-selected="false">
                                Minuman
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-auto ms-auto"> <!-- Align to the right -->
                    <div class="d-flex justify-content-end align-items-center gap-2 mt-2">
                        <input type="text" class="form-control w-auto" id="searchInput" placeholder="Cari produk...">
                    </div>
                </div>
            </div>
        </div>
        <!-- Tables -->
        <div class="tab-content">
            <!-- Search results -->
            <div id="search-result-container" class="mt-3" style="display: none;"></div>
            <div class="tab-pane fade show active" id="semua" role="tabpanel" aria-labelledby="brg-semua-tab">
                @include('partials.tabelproduk', ['produk' => $produk])

            </div>
            <div class="tab-pane fade" id="makanan" role="tabpanel" aria-labelledby="brg-makanan-tab">
                @include('partials.tabelproduk', ['produk' => $produkmakanan])
            </div>
            <div class="tab-pane fade" id="minuman" role="tabpanel" aria-labelledby="brg-minuman-tab">
                @include('partials.tabelproduk', ['produk' => $produkminuman])
            </div>
        </div>
    </div>

    <script src="{{ asset('js/Haikal_livesearch.js') }}"></script>

    <script>
        function loadmodaldata(id) {
            fetch(`/produk/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    console.log(data);

                    // isikan data ke modal
                    document.getElementById('modal-nama-barang').textContent = data.nama_barang || '-';
                    document.getElementById('modal-harga').textContent = data.harga || '-';
                    document.getElementById('modal-stok').textContent = data.stok || '-';
                    document.getElementById('modal-berat').textContent = data.berat || '-';
                    document.getElementById('modal-deskripsi').textContent = data.deskripsi_barang || '-';
                    document.getElementById('modal-tipe').textContent = data.tipe_barang || '-';
                    document.getElementById('modal-image').src = data.image_url || 'default-image.jpg'; // URL gambar produk
                    document.getElementById('modal-image').alt = data.nama_barang || 'Gambar Produk';

                    // tampilkan modal
                    $('#modalproduk').modal('show');
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
    @include('components.idle-timeout');
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Script buat pills -->
    <!-- <script src="{{ asset('js/Haikal_managebarang.js') }}"></script> -->
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>