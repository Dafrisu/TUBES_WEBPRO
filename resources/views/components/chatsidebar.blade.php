<!-- chatsidebar.blade -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UMKM Chat Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/Raphael_Message.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/Raphael_Chat.js') }}"></script>
    <script src="{{ asset('js/Raphael_Message.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('json/messages.json') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container-fluid d-inline-flex">
        <!-- Sidebar -->
        <nav class="d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <!-- BackButton -->
                <div class="col ms-auto px-10">
                    <div class="back-button-container">
                        <a href="{{ route('umkm.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                <!-- Profile Section -->
                <div class="profile-section text-center">
                    <img src="images/profile.png" alt="Profile Picture" class="rounded-circle mb-2" width="80" />
                    <h6>Customer Service</h6>
                    <p>Welcome, user</p>
                </div>
                <ul class="nav flex-column">
                    <li><a href="{{ view('Raphael_message_penjual') }}">Inbox</a></li>
                    <li><a href="{{ route('umkm.messages.read') }}">Sudah Dibaca</a></li>
                    <li><a href="{{ route('umkm.messages.unread') }}">Belum Dibaca</a></li>
                </ul>
            </div>
        </nav>
    </div>
</body>

</html>