<table class="table table-hover mt-3">
    <thead>
        <tr>
            <th>NO</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Quantity</th>
            <th>Berat</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($produk) && is_array($produk) && count($produk) > 0)
        @foreach ($produk as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item['nama_barang'] }}</td>
            <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
            <td>{{ $item['stok'] }}</td>
            <td>{{ $item['berat'] }} kg</td>
            <td>
                <a href="{{ route('umkm.viewupdate', $item['id']) }}">
                    <button class="btn btn-warning">Edit</button>
                </a>
                <form action="{{ route('umkm.deletebarang', $item['id']) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
                <button class="btn btn-sm btn-outline-primary" type="button"
                    onclick="loadmodaldata({{ $item['id'] }})" data-bs-toggle="modal" data-bs-target="#modalproduk">
                    <img src="{{ asset('images/show.png') }}" alt="Show" id="buka">
                </button>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="7" class="text-center">Data produk tidak tersedia.</td>
        </tr>
        @endif
    </tbody>
</table>