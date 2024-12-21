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
  <link rel="stylesheet" href="css/darryl.css">

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
      <a class="navbar-brand brand-name" href="dashboard_pembeli.html">
        <img src="assets/Sample 1 copy.png" alt="Logo" width="64" height="64" class="d-inline-block" />
        UMKMku
      </a>

      <!-- Button login/register -->
      <div class="ms-auto" id="navbar_button">
        <a href="darryl_masuk.html">
          Masuk
        </a>
      </div>
    </div>
  </nav>

  <!-- Wrapper untuk form masuk -->
  <div class="container content1">
    <div class="container" id="form_box">

      <!-- Insert bacotan formalitas -->
      <div class="fs-2 fw-bold text-center">Daftar</div>
      <div class="fs-4 fw-medium mb-4 text-center">Bergabung dengan UMKMku</div>
      <form>

        <!-- Isi Email -->
        <div class="mb-2">
          <label for="inputEmail" class="form-label">Alamat email</label>
          <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp">
        </div>

        <!-- Isi kata sandi -->
        <div class="mb-2">
          <label for="inputPassword" class="form-label">Kata sandi</label>
          <input type="password" class="form-control" id="inputPassword">
        </div>

        <!-- Konfirmasi sandi -->
        <div class="mb-2">
          <label for="konfirmasiSandi" class="form-label">Konfrimasi sandi</label>
          <input type="password" class="form-control" id="konfirmasiSandi" aria-describedby="emailHelp">
        </div>
        
        <div class="mb-4">
          <input type="checkbox" id="togglePassword"> Tunjukan sandi
        </div>

        <!-- Button masuk -->
        <div class="d-flex flex-column justify-content-center">
          <button type="button" class="btn Daftar" onclick="validate()">
            Daftar Sekarang
          </button>
        </div>

        <!-- Lempar ke daftar -->
        <div class="d-flex justify-content-center mt-2">
          <div class="fs-6">Sudah punya akun?</div>
          <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover ms-1"
            href="darryl_masuk.html">
            Masuk
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Pembungkus headline/content utama-->
  <div class="container-fluid content2">

    <!-- Row judul/introduction dan bacotan pendukung -->
    <div class="row mb-5">
      <div class="fs-1 text-center">UMKMku</div>
      <div class="fs-3 text-center">Your Gateway to Unique Local Treasures!</div>
    </div>

    <!-- Row gambar/content utama -->
    <div class="row row-cols-3 text-center">
      <div class="col-4">
        <img class="img-fluid" src="assets/widejoy.jfif" alt="widejoy">
      </div>
      <div class="col-4">
        <img class="img-fluid" src="assets/widejoy.jfif" alt="widejoy">
      </div>
      <div class="col-4">
        <img class="img-fluid" src="assets/widejoy.jfif" alt="widejoy">
      </div>
    </div>

    <!-- Row judul gambar/content utama -->
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

    <!-- Row penjelasan gambar/content utama -->
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

  <!-- Seller Story -->
  <div class="container-fluid content3">
    <!-- Row judul/introduction dan bacotan pendukung -->
    <div class="row">
      <div class="fs-1 text-center">Seller Story</div>
      <div class="fs-3 text-center">Ayo join UMKMku yeaayyy</div>
    </div>

    <div class="row">
      <div id="sellerStoryCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="3000">
            <img src="assets/img1.png" class="d-block mx-auto w-50 h-50" alt="img1">
          </div>
          <div class="carousel-item" data-bs-interval="3000">
            <img src="assets/widejoy.jfif" class="d-block mx-auto w-50 h-50" alt="widejoy">
          </div>
          <div class="carousel-item" data-bs-interval="3000">
            <img src="assets/img2.png" class="d-block mx-auto w-50 h-50" alt="img2">
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

  <!-- Connect Bootsrap bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <!-- Connect Custom JS -->
  <script src="javascript/darryl.js"></script>
</body>

</html>