<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKMku</title>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/fersya_inbox_2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Dafa_Dashboard.css') }}">
    <!-- Import Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Merriweather:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            umkm_message: "/message",
            umkm_inbox: "{{ route('umkm.inbox') }}"
        };
    </script>

    <x-semua_-sidebar />

<div class="container">
    <h2>Tambah Campaign</h2>
    <a href="{{ route('umkm.inbox') }}" class="btn btn-secondary mb-3 ">
        Kembali ke Inbox
    </a>
    <!-- Form for Adding a New Campaign -->
    <form action="{{ route('umkm.addcampaign') }}" method="POST">
        @csrf
        <!-- Title Field -->
        <div class="form-group mb-3">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title')}}" required>
        </div>

        <!-- Description Field -->
        <div class="form-group mb-3">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description')}}</textarea>
        </div>
        <div class="form-group mb-3">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>

            </div>

            <!-- End Date Field -->
            <div class="form-group mb-3">
                <label for="end_date">Tanggal Berakhir</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}"
                    required>
            </div>

            <!-- Image Upload Field -->
            <div class="form-group mb-3">
                <label for="image">Gambar (Opsional)</label>
                <input type="file" name="image_url" id="image_url" class="form-control" value="{{ old('image_url') }}">
            </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary" id="btn_tambahcampaign">Tambah Campaign</button>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/fersya_inbox.js') }}"></script>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
</body>

</html>