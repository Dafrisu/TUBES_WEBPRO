<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        .submenu {
            display: none;
            padding-left: 20px;
        }

        .submenu.active {
            display: block;
        }

        .submenu li {
            border: none;
        }

        #dropdownArrow {
            height: 1rem;
            rotate: 270deg;
            transition: transform 0.3s;
        }

        /* Stats card hover effect */
        .stats-card {
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        /* Container for Pesanan menu */
        .container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Seller Center</h2>
        <ul>
            <li><a href="Dafa_Dashboard.html">Dashboard</a></li>
            <li><a href="Haikal_ManageBarang.html">Manage Products</a></li>
            <ul>
                <li onclick="toggleSubmenu()">
                    <div class="container">
                        Pesanan
                        <img src="assets/arrow-down-sign-to-navigate.png" alt="dropdownArrow" id="dropdownArrow"
                            style="margin-left: 8px;">
                    </div>
                </li>
                <ul id="submenu" class="submenu">
                    <li><a href="Dafa_kelolaPesanan.html">Kelola Pesanan</a></li>
                    <li><a href="Dafa_pesananDiterima.html">Pesanan Diterima</a></li>
                    <li><a href="Dafa_pesananDitolak.html">Pesanan Ditolak</a></li>
                    <li><a href="Dafa_pesananSelesai.html">Pesanan Selesai</a></li>
                </ul>
            </ul>
            <li><a href="Mahesa_Mahesa_Statistik_Penjualan.html">Statistics</a></li>
            <li><a href="Raphael_message_penjual.html">Kotak Masuk</a></li>
            <li><a href="fersya_inbox_penjual_prioritas.html">Inbox Penjual</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <h1 class="mb-4">Dashboard</h1>

            <!-- Stats Cards -->
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card stats-card border-primary border-top border-3">
                        <div class="card-body">
                            <div class="text-muted mb-2">Sales</div>
                            <h3 class="mb-2" id="salesValue">Loading...</h3>
                            <small class="text-success d-flex align-items-center">
                                <span class="me-1">↑</span>
                                <span id="salesChange">Loading...</span>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card stats-card border-success border-top border-3">
                        <div class="card-body">
                            <div class="text-muted mb-2">Orders</div>
                            <h3 class="mb-2" id="ordersValue">Loading...</h3>
                            <small class="text-success d-flex align-items-center">
                                <span class="me-1">↑</span>
                                <span id="ordersChange">Loading...</span>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card stats-card border-info border-top border-3">
                        <div class="card-body">
                            <div class="text-muted mb-2">Visitors</div>
                            <h3 class="mb-2" id="visitorsValue">Loading...</h3>
                            <small class="text-success d-flex align-items-center">
                                <span class="me-1">↑</span>
                                <span id="visitorsChange">Loading...</span>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card stats-card border-warning border-top border-3">
                        <div class="card-body">
                            <div class="text-muted mb-2">Views</div>
                            <h3 class="mb-2" id="viewsValue">Loading...</h3>
                            <small class="text-success d-flex align-items-center">
                                <span class="me-1">↑</span>
                                <span id="viewsChange">Loading...</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Chart -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Overview</h5>
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- External JavaScript File -->
    <script src="javascript/Mahesa_Statistik.js"></script>
</body>

</html>