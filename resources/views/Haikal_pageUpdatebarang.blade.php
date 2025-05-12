<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Barang</title>
    <link rel="stylesheet" href="{{ asset('css/Dafa_Dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <div class="headertitle text-center">
            <h2 id="headtitle">Update barang</h2>

        </div>
        <div class="container container-sm w-50 border">

            <form id="formbarang" method="post" action="{{route('umkm.updateproduk', $produk['id'])}}">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 20px;" class="mt-3">
                    <p><label for="id_namabarang">Nama Barang</label></p>
                    <p><input type="text" name="nama_barang" class="form-control" placeholder="Nama"
                            id="id_namabarang"
                            value="{{old('nama_barang', $produk['nama_barang'])}}"
                            required>
                    </p>
                </div>
                <div style="margin-bottom: 20px;">
                    <p><label for="id_harga">Harga Barang</label></p>
                    <p><input type="number" name="harga" class="form-control" placeholder="Harga" id="id_harga"
                            value="{{old('harga', $produk['harga'])}}"
                            required>
                    </p>
                </div>
                <div style="margin-bottom: 20px;">
                    <p><label for="id_stok">Jumlah Barang</label></p>
                    <p><input type="number" name="stok" class="form-control" placeholder="QTY" id="id_stok"
                            value="{{old('stok', $produk['stok'])}}"
                            required></p>
                </div>
                <label for="tipe_barang" class="form-label mt-3">Tipe Produk</label>
                <select class="form-select border mb-5 w-50" id="tipe_barang" name="tipe_barang">
                    <option value="Makanan" {{ old('tipe_barang', $produk['tipe_barang']) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="Minuman" {{ old('tipe_barang', $produk['tipe_barang']) == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                </select>
                <div style="margin-bottom: 20px;">
                    <label for="">Deskripsi</label>
                    <div class="form-floating">
                        <textarea name="deskripsi_barang" id="id_desc" class="form-control">{{old('deskripsi_barang', $produk['deskripsi_barang'])}}</textarea>
                    </div>
                </div>
                <div style="margin-bottom: 20px;">
                    <label for="">Berat</label>
                    <input type="number" name="berat" class="form-control" placeholder="berat" id="id_berat"
                        value="{{old('berat', $produk['berat'])}}"
                        required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" id="addbarangbtn">
                        Update Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
    @include('components.idle-timeout');
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
</body>

</html>