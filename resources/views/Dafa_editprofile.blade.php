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
        <a href="{{ route('umkm.dashboard') }}">
            <img src="{{ asset('/images/backbutton.png') }}" alt="" id="iconback">
        </a>
        <h2 class="form-header">Edit Profile UMKM</h2>
        <form id="formeditprofileumkm" method="POST"
            action="{{ route('umkm.editprofileumkm', session('umkmID')) }}">
            @csrf
            @method('PUT')
            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap"
                    value="{{ old('nama_lengkap', $profile['nama_lengkap']) }}"
                    class="form-control" required>
            </div>
            <!-- Nomor Telepon -->
            <div class="mb-3">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="tel" id="nomor_telepon" name="nomor_telepon"
                    value="{{ old('nomor_telepon', $profile['nomor_telepon']) }}"
                    class="form-control" required>
            </div>
            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea id="alamat" name="alamat" class="form-control" rows="3"
                    required>{{ old('alamat', $profile['alamat']) }}</textarea>
            </div>
            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control"
                    value="{{ old('username', $profile['username']) }}"
                    required>
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', $profile['email']) }}"
                    class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password"
                        value="{{ old('password', $profile['password']) }}"
                        class="form-control" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <svg id='hide_password' xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                            <path
                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                            <path
                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                        </svg>
                        <svg id='show_password' xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </button>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <!-- Nama Usaha -->
            <div class="mb-3">
                <label for="nama_usaha" class="form-label">Nama Usaha</label>
                <input type="text" id="nama_usaha" name="nama_usaha"
                    value="{{ old('nama_usaha', $profile['nama_usaha']) }}"
                    class="form-control" required>
            </div>
            <!-- NIK KTP -->
            <div class="mb-3">
                <label for="NIK_KTP" class="form-label">NIK KTP</label>
                <input type="text" id="NIK_KTP" name="NIK_KTP"
                    value="{{ old('NIK_KTP', $profile['NIK_KTP']) }}"
                    class="form-control">
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-submit">Simpan Perubahan</button>
        </form>
    </div>
    @include('components.idle-timeout');
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-zJ5rcOfKLiE3AcIshe6EEkzwDM98IJM3Gs3gR4kEHyDiUHCpD3Wn8KVpjTAxgITP" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const togglePassword = document.getElementById("togglePassword");
            const passwordInput = document.getElementById("password");
            const showPasswordIcon = document.getElementById("show_password");
            const hidePasswordIcon = document.getElementById("hide_password");

            // Sembunyikan ikon 'show' saat awal (karena default: password mode)
            showPasswordIcon.style.display = "none";

            togglePassword.addEventListener("click", function () {
                const isPassword = passwordInput.getAttribute("type") === "password";
                passwordInput.setAttribute("type", isPassword ? "text" : "password");

                // Toggle ikon
                if (isPassword) {
                    showPasswordIcon.style.display = "inline";
                    hidePasswordIcon.style.display = "none";
                } else {
                    showPasswordIcon.style.display = "none";
                    hidePasswordIcon.style.display = "inline";
                }
            });
        });

    </script>
</body>

</html>
