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
        .addproduk {
            display: inline-block;
            padding: 10px 20px;
            background-color: #658864;
            color: white;   
            border-radius: 4px;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #3e583d;
        }

        #id_manage {
            background-color: grey;
            opacity: 50%;
        }
        #tambahbarang a button{
            text-decoration: none;
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
    <Sidebar-component></Sidebar-component>
    
    <!-- Modal untuk input barang ( gak jadi dipake )
    <div class="modal fade" id="modaltambahbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="labelmodal">Input Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    Isi modal di sini
                    <p>Masukkan detail produk baru Anda di sini.</p>
                    <form id="formBarang">
                        <div class="mb-2">
                            <label for="id_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="id_barang" required>
                        </div>
                        <div class="mb-2">
                            <label for="id_harga">Harga Barang</label>
                            <input type="text" class="form-control" id="id_harga" placeholder="RP." required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="savedata">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- yang membungkus -->
    <div class="container ms-4 me-4 mt-4">
        <div class="d-flex align-items-center">
            <div class="fs-3 align-bottom">Kelola Produk</div>
            <div class="ms-auto" id="tambahbarang"><a href="{{ route('umkm.tambahbarang') }}"><button class="btn ms-auto addproduk">tambah</button></a></div>
        </div>

        <!-- container dan opsi -->
        <div class="container-sm mt-3">
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
                </tr>
            </thead>
            <tbody id="produktable">
                <!-- isi tabel dari json dan js -->
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    <!-- Script buat pills -->
    <script src="{{ asset('js/Haikal_managebarang.js') }}"></script>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>

</body>

</html>