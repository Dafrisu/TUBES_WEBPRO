<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>UMKMku</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.2/particles.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    {{-- Connect icons bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('css/darryl.css') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Merriweather:wght@400;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <canvas class="background"></canvas>

    <nav class="navbar fixed-top">

        <div class="container-fluid">
            <a class="navbar-brand brand-name" href="{{ route('umkm.landing') }}">
                <img src="{{ asset('images/logoU.png') }}" alt="Logo" width="64" height="64"
                    class="d-inline-block" />
                UMKMku
            </a>

            <div class="ms-auto" id="navbar_button">
                <a href="{{ route('umkm.masuk') }}">
                    Masuk
                </a>
            </div>
        </div>
    </nav>

    <div class="container content1">
        <div class="container" id="form_box">

            <div class="fs-2 fw-bold text-center">Daftar</div>
            <div class="fs-4 fw-medium mb-4 text-center">Bergabung dengan UMKMku</div>

            @if (session('error'))
                <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            <form action="{{ route('umkm.daftar') }}" method="POST" onsubmit="return validate(event)">
                @csrf
                <div class="mb-2">
                    <label for="namaLengkap" class="form-label">Nama lengkap</label>
                    <input type="text" class="form-control @error('namaLengkap') is-invalid @enderror"
                        id="namaLengkap" name="namaLengkap" value="{{ old('namaLengkap') }}"
                        placeholder="Masukkan nama lengkap Anda" required>
                    @error('namaLengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="namaUsaha" class="form-label">Nama Usaha</label>
                    <input type="text" class="form-control @error('namaUsaha') is-invalid @enderror" id="namaUsaha"
                        name="namaUsaha" value="{{ old('namaUsaha') }}"
                        placeholder="Cth: Warung Makan Bu Juju">
                    @error('namaUsaha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" value="{{ old('username') }}"
                        placeholder="Cth: username_anda" required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="inputEmail" class="form-label">Alamat email</label>
                    <input type="email" class="form-control @error('inputEmail') is-invalid @enderror" id="inputEmail"
                        name="inputEmail" value="{{ old('inputEmail') }}"
                        placeholder="Cth: nama@gmail.com" required>
                    @error('inputEmail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 position-relative">
                    <label for="inputPassword" class="form-label">Kata sandi</label>
                    <input type="password" class="form-control @error('inputPassword') is-invalid @enderror"
                        id="inputPassword" name="inputPassword" placeholder="Masukkan kata sandi" required>
                    <i class="bi bi-eye-slash-fill password-toggle" id="togglePasswordIcon"
                        aria-label="Toggle password visibility"></i>
                    @error('inputPassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 position-relative">
                    <label for="konfirmasiSandi" class="form-label">Konfirmasi kata sandi</label>
                    <input type="password"
                        class="form-control @error('konfirmasiSandi_confirmation') is-invalid @enderror"
                        id="konfirmasiSandi" name="konfirmasiSandi"
                        placeholder="Konfirmasi kata sandi Anda" required>
                    <i class="bi bi-eye-slash-fill password-toggle" id="toggleConfirmPasswordIcon"
                        aria-label="Toggle password visibility"></i>
                    @error('konfirmasiSandi_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control @error('nomorTelepon') is-invalid @enderror"
                        id="nomorTelepon" name="nomorTelepon" value="{{ old('nomorTelepon') }}"
                        placeholder="Cth: 081234567890" required>
                    @error('nomorTelepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                        name="alamat" value="{{ old('alamat') }}"
                        placeholder="Cth: Jl. Contoh No. 123, Kota Contoh">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nikKtp" class="form-label">NIK KTP</label>
                    <input type="text" class="form-control @error('nikKtp') is-invalid @enderror" id="nikKtp"
                        name="nikKtp" value="{{ old('nikKtp') }}"
                        placeholder="Masukkan NIK KTP Anda" required>
                    @error('nikKtp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex flex-column justify-content-center">
                    <button type="submit" class="btn">Daftar Sekarang</button>
                </div>

                <div class="d-flex justify-content-center mt-2">
                    <div class="fs-6">Sudah punya akun?</div>
                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover ms-1"
                        href="{{ route('umkm.masuk') }}">Masuk</a>
                </div>

                @if (
                    $errors->any() &&
                        !$errors->has('namaLengkap') &&
                        !$errors->has('nomorTelepon') &&
                        !$errors->has('username') &&
                        !$errors->has('inputEmail') &&
                        !$errors->has('inputPassword') &&
                        !$errors->has('namaUsaha') &&
                        !$errors->has('nikKtp') &&
                        !$errors->has('alamat'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
            </form>
        </div>
    </div>

    <div class="container-fluid content2">

        <div class="row mb-5">
            <div class="fs-1 text-center">UMKMku</div>
            <div class="fs-3 text-center">Your Gateway to Unique Local Treasures!</div>
        </div>

        <div class="row row-cols-3 text-center">
            <div class="col-4">
                <img class="img-fluid" src="{{ asset('images/widejoy.jfif') }}" alt="widejoy">
            </div>
            <div class="col-4">
                <img class="img-fluid" src="{{ asset('images/widejoy.jfif') }}" alt="widejoy">
            </div>
            <div class="col-4">
                <img class="img-fluid" src="{{ asset('images/widejoy.jfif') }}" alt="widejoy">
            </div>
        </div>

        <div class="row row-cols-3 text-center">
            <div class="col-4">
                Widejoy A
            </div>
            <div class="col-4">
                Widejoy B
            </div>
            <div class="col-4">
                Widejoy C
            </div>
        </div>

        <div class="row row-cols-3 text-center">
            <div class="col-4">
                Widejoy A is wide
            </div>
            <div class="col-4">
                Widejoy B is wide
            </div>
            <div class="col-4">
                Widejoy C is wide
            </div>
        </div>
    </div>

    <div class="container-fluid content3">
        <div class="row">
            <div class="fs-1 text-center">Seller Story</div>
            <div class="fs-3 text-center">Ayo join UMKMku yeaayyy</div>
        </div>

        <div class="row">
            <div id="sellerStoryCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="3000">
                        <img src="{{ asset('images/img1.png') }}" class="d-block mx-auto w-50 h-50" alt="img1">
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="{{ asset('images/img2.png') }}" class="d-block mx-auto w-50 h-50" alt="img1">
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="{{ asset('images/widejoy.jfif') }}" class="d-block mx-auto w-50 h-50"
                            alt="widejoy">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid text-center content4">
        <div class="fs-1">
            Simple and easy to start your business
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="{{ asset('js/darryl.js') }}"></script>
</body>

</html>