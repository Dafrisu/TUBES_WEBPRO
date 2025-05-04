<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="umkm-id" content="{{ session('umkmID') ?? 0 }}">
    <title>Dashboard Statistik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .sidebar {
            width: 250px;
            background-color: #658864;
            padding: 20px;
            color: #fff;
            height: 100vh;
        }

        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .sidebar ul {
            list-style-type: none;
        }

        .sidebar ul li {
            padding: 15px 0;
            cursor: pointer;
        }

        .sidebar ul li:hover {
            background-color: #444444;
            padding-left: 10px;
            transition: 0.3s;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f4f4f4;
            max-width: 100%;
        }

        .stats-card {
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        /* Product table styles */
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid #dee2e6;
            width: 100%;
        }
        
        #productTable {
            width: 100%;
            min-width: 800px; /* Ensures minimum width */
            margin-bottom: 0;
        }
        
        #productTable th {
            white-space: nowrap;
            background-color: #f8f9fa;
            font-size: 1.05rem;
        }
        
        #productTable td, #productTable th {
            padding: 0.75rem 1.25rem;
            vertical-align: middle;
        }
        
        #productTable tbody tr:last-child {
            border-bottom: 1px solid #dee2e6;
        }
        
        #productTable tfoot th {
            background-color: #f1f1f1;
            font-size: 1.05rem;
        }

        /* Make card take full width of container */
        .card {
            width: 100%;
        }

        /* Override Bootstrap container max-width if needed */
        @media (min-width: 1200px) {
            .container-fluid {
                max-width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <script>
        window.routes = {
            umkm_dashboard: "{{ route('umkm.dashboard') }}",
            umkm_managebarang: "{{ route('umkm.managebarang') }}",
            umkm_kelolapesanan: "{{ route('umkm.kelolapesanan') }}",
            umkm_pesananditerima: "{{ route('umkm.pesananditerima') }}",
            umkm_pesananditolak: "{{ route('umkm.pesananditolak') }}",
            umkm_pesananselesai: "{{ route('umkm.pesananselesai') }}",
            umkm_statistik: "{{ route('umkm.statistik') }}",
            umkm_message: "{{ route('umkm.message') }}",
            umkm_inbox: "{{ route('umkm.inbox') }}",
        };
    </script>

    <x-semua_-sidebar />

    <div class="main-content">
        <div class="container-fluid p-0">
            <h1 class="mb-4">Statistik Penjualan dan Pesanan</h1>

            <div class="mb-4">
                <label class="form-label">Pilih Periode</label>
                <div class="row">
                    <div class="col-md-3">
                        <select id="yearSelect" class="form-select mb-2 mb-md-0">
                            <option value="">-- Pilih Tahun --</option>
                            <!-- Years will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="monthSelect" class="form-select">
                            <option value="">-- Pilih Bulan (Opsional) --</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card stats-card border-primary border-top border-3">
                        <div class="card-body">
                            <div class="text-muted mb-2"> Total Penjualan</div>
                            <h3 class="mb-2" id="salesValue">Loading...</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card stats-card border-success border-top border-3">
                        <div class="card-body">
                            <div class="text-muted mb-2">Total Pesanan</div>
                            <h3 class="mb-2" id="ordersValue">Loading...</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <canvas id="salesChart" width="400" height="150"></canvas>
                </div>
            </div>

            <!-- Product Sales Overview Section -->
            <div class="row mt-4">
                <div class="col-12" id="productStats">
                    <!-- Product stats will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    @include('components.idle-timeout');
    <script src="{{ asset('js/Mahesa_Statistik.js') }}"></script>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
</body>

</html>