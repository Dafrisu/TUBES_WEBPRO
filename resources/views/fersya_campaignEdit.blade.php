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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    
    <h2>Edit Campaign</h2>

    <!-- Form for Editing the Campaign -->
    <form action="{{ route('umkm.editcampaign', ['id' => $datacampaign[0]['id_campaign']]) }}" method="PUT">
        @csrf
        @method('PUT')
        <!-- Title Field -->
        <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $datacampaign[0]['title']) }}" required>
        </div>

        <!-- Description Field -->
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $datacampaign[0]['description']) }}</textarea>
        </div>

        <!-- Start Date Field -->
        <div class="form-group mb-3">
            <label for="start_date">start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $datacampaign[0]['start_date']) }}" required>
        </div>

        <!-- End Date Field -->
        <div class="form-group mb-3">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $datacampaign[0]['end_date']) }}" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Campaign</button>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/fersya_inbox.js') }}"></script>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
</body>
</html>