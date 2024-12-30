$(document).ready(function () {
    const umkmId = 1; // Hardcoded for now
    let salesChart;

    // Event listener for dropdown change
    $('#monthSelect').change(function () {
        const selectedValue = $(this).val();
        const currentYear = new Date().getFullYear();

        // Check if the selected value is "yearly"
        if (selectedValue === "yearly") {
            fetchYearlyStats(umkmId);
        } else if (selectedValue) {
            const month = parseInt(selectedValue);
            fetchDailyStats(umkmId, month, currentYear);
        } else {
            resetChart();
        }
    });

    function fetchDailyStats(umkmId, month, year) {
        const url = `https://umkmapi.azurewebsites.net/daily-stats/${umkmId}?month=${month}&year=${year}`;

        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                updateStats(data);
                updateChart(data);
            },
            error: function (error) {
                console.error('Error fetching daily stats:', error);
                $('#salesValue').text('Terjadi kesalahan');
                $('#ordersValue').text('Terjadi kesalahan');
            }
        });
    }

    function fetchYearlyStats(umkmId) {
        const url = `https://umkmapi.azurewebsites.net/monthly-stats/${umkmId}`;

        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                updateStats(data);
                updateChart(data, 'yearly');
            },
            error: function (error) {
                console.error('Error fetching yearly stats:', error);
                $('#salesValue').text('Terjadi kesalahan');
                $('#ordersValue').text('Terjadi kesalahan');
            }
        });
    }

    function updateStats(data) {
        const totalSales = data.reduce((sum, record) => sum + record.total_sales, 0);
        const totalOrders = data.reduce((sum, record) => sum + record.total_orders, 0);

        $('#salesValue').text(`Rp${totalSales.toFixed(2)}`);
        $('#ordersValue').text(totalOrders);
    }

    function updateChart(data, type = 'daily') {
        const labels = type === 'yearly'
            ? data.map(record => monthNames[record.month - 1])
            : data.map(record => record.tanggal);
        const salesData = data.map(record => record.total_sales);
        const ordersData = data.map(record => record.total_orders);

        if (salesChart) {
            salesChart.destroy();
        }

        salesChart = new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Penjualan',
                        data: salesData,
                        backgroundColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                    },
                    {
                        label: 'Total Pesanan',
                        data: ordersData,
                        backgroundColor: 'rgba(192, 75, 192, 1)',
                        borderWidth: 2,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    const monthNames = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    function resetChart() {
        if (salesChart) {
            salesChart.destroy();
        }
        $('#salesValue').text('');
        $('#ordersValue').text('');
    }
});