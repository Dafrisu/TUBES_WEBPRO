<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>UMKMku</title>
  <!-- External buat background -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.2/particles.min.js"></script>
  
  <!-- Conect CSS bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  
  <!-- Connect CSS -->
  <link rel="stylesheet" href="{{ asset('css/darryl.css') }}">
  
  <!-- Import Fonts -->
  <link
  href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Merriweather:wght@400;700&display=swap"
  rel="stylesheet">
</head>

<body>
  <!-- Background -->
  <canvas class="background"></canvas>

  <!-- Navbar -->
  <nav class="navbar fixed-top">

    <div class="container-fluid">
      <!-- navigate to home/dashboard by clicking logo/name -->
      <a class="navbar-brand brand-name" href="{{ route('umkm.landing') }}">
        <img src="{{ asset('images/logoU.png') }}" alt="Logo" width="64" height="64" class="d-inline-block" />
        UMKMku
      </a>

      <!-- Button login/register -->
      <div class="ms-auto" id="navbar_button">
        <a href="{{ route('umkm.masuk') }}">
          Masuk
        </a>
      </div>
    </div>
  </nav>

  <!-- Wrapper untuk form masuk -->
  <div class="container content1">
    <div class="container" id="form_box">
      @if (session('error'))
      <div class="alert alert-danger">
        {{session('error')}}
      </div>
      @endif
      <!-- Insert bacotan formalitas -->
      <div class="fs-2 fw-bold text-center">Lupa kata sandi?</div>
      <div class="fs-4 fw-medium mb-4 text-center">Masukan email untuk mengubah kata sandi</div>
      <form action="" method="POST" onsubmit="">
        @csrf
        <!-- Isi Email -->
        <div class="mb-2">
          <label for="inputEmail" class="form-label">Alamat email</label>
          <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Masukan email anda" required>
        </div>

<!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
</svg> -->

        
        <!-- Button masuk -->
        <div class="d-flex flex-column justify-content-center">
          <button type="submit" class="btn">
            Kirim
          </button>
        </div>

        <!-- Lempar ke daftar -->
        <div class="d-flex justify-content-center mt-2">
          <div class="fs-6">Tidak mendapat email?</div>
          <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover ms-1"
            href="{{ route('umkm.auth') }}">
            Kirim ulang
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Connect Bootsrap bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <!-- Connect Custom JS -->
  <script src="{{ asset('js/darryl.js') }}"></script>
</body>

</html>