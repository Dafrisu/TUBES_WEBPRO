<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        /* Sidebar styling */
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

        /* Main content area styling */
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f4f4f4;
        }

        /* Stats card hover effect */
        .stats-card {
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
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


    <sidebar-component>
    </sidebar-component>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <h1 class="mb-4">Sales and Orders Statistics</h1>

            <!-- Month Selector -->
            <div class="mb-4">
                <label for="monthSelect" class="form-label">Select Month or Year</label>
                <select id="monthSelect" class="form-select">
                    <option value="">-- Select Month or Year --</option>
                    <option value="yearly">Yearly</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>

 <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card stats-card border-primary border-top border-3">
                        <div class="card-body">
                            <div class="text-muted mb-2">Total Sales</div>
                            <h3 class="mb-2" id="salesValue">Loading...</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card stats-card border-success border-top border-3">
                        <div class="card-body">
                            <div class="text-muted mb-2">Total Orders</div>
                            <h3 class="mb-2" id="ordersValue">Loading...</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Container -->
            <div class="row">
                <div class="col-md-12">
                    <canvas id="salesChart" width="400" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- External JavaScript File -->
    <script src="{{ asset('js/Mahesa_Statistik.js') }}"></script>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
</body>

</html>