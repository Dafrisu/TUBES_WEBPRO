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
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Bar -->
        <div class="header-bar">
            <h1>Welcome to Seller Dashboard</h1>
            <div class="profile">
                <a
                    href="{{ route('umkm.getprofileumkm', session('umkmID')) }}">
                    <img src="{{ asset('images/profile.png') }}" alt="Profile Image">
                </a>
                <span>{{ $profile['username'] }}</span>
            </div>
        </div>
        <script src="{{ asset('js/Dafa_Dashboard.js') }}"></script>
</body>

</html>
