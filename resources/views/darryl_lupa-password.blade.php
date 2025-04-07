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
      <form action="{{ route('umkm.lupa-password') }}" method="POST">
        @csrf
        <!-- Isi Email -->
        <div class="mb-2">
          <label for="inputEmail" class="form-label">Alamat email</label>
          <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Masukan email anda" required>
        </div>
        
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
            href="{{ route('umkm.lupa-password') }}">
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