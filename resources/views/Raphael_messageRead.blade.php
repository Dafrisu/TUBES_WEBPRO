<!-- Raphael_messageRead.blade -->
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
        <nav class="sidebar d-md-block bg-light" id="sidebar">
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
                    <img src="{{ asset('images/profile.png') }}" alt="Profile Picture" class="rounded-circle mb-2"
                        width="80" />
                    <h6>Customer Service</h6>
                    <p>Welcome, user</p>
                </div>
                <li onclick="toggledropdown()">
                    <div class="container">
                        Kotak Masuk
                    </div>
                </li>
                <ul id="submenu" class=" submenu nav flex-column collapsed">
                    <li><a href="{{ route('umkm.messages.inbox') }}">Inbox</a></li>
                    <li><a href="{{ route('umkm.messages.read') }}">Sudah Dibaca</a></li>
                    <li><a href="{{ route('umkm.messages.unread') }}">Belum Dibaca</a></li>
                </ul>
            </div>
        </nav>
        <div class="col ms-auto px-4">
            <div class="justify-content-between align-items-center pt-1 pb-1 mb-3 border-bottom">
                <div class="header-logo">
                    <img src="{{ asset('images/logoU.png') }}" alt="UMKM Icon" width="80" />
                    <h1 class="h2 mb-0">UMKM CHAT</h1>
                </div>
            </div>

            <!-- Filters Bar -->
            <div class="filters-bar-container" id="filtersBar">
                <div class="filters-bar d-flex align-items-center">
                    <input type="text" class="form-control flex-grow-1 me-3" placeholder="Cari semua chat"
                        onkeyup="searchMessages(event)" />
                    <select class="form-select" style="width: auto;" onchange="sortMessages(event)">
                        <option value="">Urutkan</option>
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                    </select>
                </div>
                <p class="text-center" id="emptyMessage">
                    Daftar ini kosong
                </p>
            </div>

            <!-- Chat Interface -->
            <div class="chat-interface d-flex flex-column" id="chatInterface">
                @if (!empty($unreadMessages))
                    @foreach (collect($unreadMessages)->unique('id_pembeli') as $message)
                        @if (!empty($message['id_pembeli']))
                            <a href="{{ route('messagepage', $message['id_pembeli']) }}">
                                <div class="colspan-1 card mb-2" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $message['nama_lengkap'] }}</h5>
                                        <p class="card-text">{{ $message['message'] }}</p>
                                        <p class="text-muted">{{ date('H:i:s', strtotime($message['sent_at'])) }}</p>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                @else
                    <p>No read messages found.</p>
                @endif
            </div>

            <!-- Example Message Section -->
            <div class="example-messages-container">
                <div class="example-messages" id="exampleMessages">
                </div>
            </div>
        </div>
    </div>
</body>

</html>