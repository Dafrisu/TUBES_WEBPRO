<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambahkan barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/haikal_manage.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* misc */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .headertitle {
            width: 100%;
            height: 50px;
            background-color: #658864;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        #headtitle {
            font-size: 24px;
            font-family: Arial, sans-serif;
        }

        #formbarang {
            margin-top: 20px;
            text-align: left;
            margin-left: 20px;
            font-size: 16px;
        }

        #formbarang input {
            width: 50%;
            height: auto;
            max-width: 500px;
        }

        .btn {
            background-color: #658864;
        }
    </style>
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

    <div class="main-content">
        <div class="headertitle">
            <h2 id="headtitle">Tambah barang</h2>

        </div>
        @if (session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        @endif
        <form id="formbarang" method="post" action="{{route('umkm.addbarang')}}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 20px;">
                <p><label for="id_namabarang">Nama Barang</label></p>
                <p><input type="text" name="nama_barang" class="form-control" placeholder="Nama" id="id_namabarang" required></p>
            </div>
            <div style="margin-bottom: 20px;">
                <p><label for="id_harga">Harga Barang</label></p>
                <p><input type="number" name="harga" class="form-control" placeholder="Harga" id="id_harga" required></p>
            </div>
            <div style="margin-bottom: 20px;">
                <p><label for="id_stok">Jumlah Barang</label></p>
                <p><input type="number" name="stok" class="form-control" placeholder="QTY" id="id_stok" required></p>
            </div>
            <label for="tipe_barang" class="form-label mt-3">Tipe Produk</label>
            <select class="form-select border mb-5 w-50" id="tipe_barang" name="tipe_barang">
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
            </select>
            <div style="margin-bottom: 20px;">
                <label for="">Deskripsi</label>
                <div class="form-floating w-50">
                    <textarea name="deskripsi_barang" id="id_desc" class="form-control"></textarea>
                </div>
            </div>
            <div style="margin-bottom: 20px;">
                <label for="">Berat</label>
                <input type="number" name="berat" class="form-control" placeholder="berat" id="id_berat" required>
            </div>
            <div style="margin-bottom: 20px;">
                <label for="id_gambar" class="form-label">Tambah Gambar</label>
                <div id="upload-container" style="width: 200px; height: 200px; border: 2px dashed #658864; display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative; overflow: hidden;">
                    <span id="upload-icon" style="font-size: 48px; color: #658864;">+</span>
                    <input type="file" name="foto" id="id_gambar" accept="image/*"
                        style="opacity: 0; width: 100%; height: 100%; position: absolute; top: 0; left: 0; cursor: pointer;">
                    <img id="preview-image" src="" alt="Preview" style="max-width: 100%; max-height: 100%; display: none; position: absolute; top: 0; left: 0; object-fit: cover;">
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" id="addbarangbtn">
                    Tambahkan Barang
                </button>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>

    <!-- script untuk gambar -->
    <script>
        const fileInput = document.getElementById('id_gambar');
        const previewImage = document.getElementById('preview-image');
        const uploadIcon = document.getElementById('upload-icon');
        const uploadContainer = document.getElementById('upload-container');

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    // Display the image preview
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    uploadIcon.style.display = 'none'; // Hide the "+" icon
                };

                reader.readAsDataURL(file);
            } else {
                // Reset preview if no file is selected
                previewImage.src = '';
                previewImage.style.display = 'none';
                uploadIcon.style.display = 'block'; // Show the "+" icon
            }
        });
    </script>

</body>

</html>