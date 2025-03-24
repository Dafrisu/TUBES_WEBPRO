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
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
    <div class="container">
    <h2 class="mb-4">Daftar Pendaftaran Kurir</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Kurir</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kurirList as $index => $kurir)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kurir->name }}</td>
                    <td>{{ $kurir->email }}</td>
                    <td>{{ $kurir->phone }}</td>
                    <td>
                        <form action="{{ route('kurir.terima', $kurir->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Terima</button>
                        </form>
                        
                        <form action="{{ route('kurir.tolak', $kurir->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada pendaftaran kurir.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
    <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
</body>

</html>