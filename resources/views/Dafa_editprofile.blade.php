<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-submit {
            width: 100%;
        }

        #iconback {
            height: 1rem;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <a href="{{route('umkm.dashboard')}}">
            <img src="{{asset('/images/backbutton.png')}}" alt="" id="iconback">
        </a>
        <h2 class="form-header">Edit Profile UMKM</h2>
        <form id="formeditprofileumkm" method="POST" action="{{route('umkm.editprofileumkm', session('umkmID'))}}">
            @csrf
            @method('PUT')
            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                <input type="text" id="namaLengkap" name="namaLengkap"
                    value="{{old('nama_lengkap', $profile['nama_lengkap'])}}" class="form-control" required>
            </div>
            <!-- Nomor Telepon -->
            <div class="mb-3">
                <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                <input type="tel" id="nomorTelepon" name="nomorTelepon"
                    value="{{old('nomor_telepon', $profile['nomor_telepon'])}}" class="form-control" required>
            </div>
            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea id="alamat" name="alamat" class="form-control" rows="3"
                    required>{{old('alamat', $profile['alamat'])}}</textarea>
            </div>
            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control"
                    value="{{old('username', $profile['username'])}}" required>
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" value="{{old('email', $profile['email'])}}"
                    class="form-control" required>
            </div>
            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" id="password" name="password" value="{{old('password', $profile['password'])}}"
                    class="form-control" required>
            </div>
            <!-- Nama Usaha -->
            <div class="mb-3">
                <label for="namaUsaha" class="form-label">Nama Usaha</label>
                <input type="text" id="namaUsaha" name="namaUsaha" value="{{old('nama_usaha', $profile['nama_usaha'])}}"
                    class="form-control" required>
            </div>
            <!-- NIK KTP -->
            <div class="mb-3">
                <label for="nikKtp" class="form-label">NIK KTP</label>
                <input type="text" id="nikKtp" name="nikKtp" value="{{old('NIK_KTP', $profile['NIK_KTP'])}}"
                    class="form-control">
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-submit">Simpan Perubahan</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-zJ5rcOfKLiE3AcIshe6EEkzwDM98IJM3Gs3gR4kEHyDiUHCpD3Wn8KVpjTAxgITP"
        crossorigin="anonymous"></script>
</body>

</html>