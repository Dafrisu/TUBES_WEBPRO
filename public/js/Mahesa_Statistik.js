$(document).ready(function () {
    const umkmId = 2; // Replace with the actual UMKM ID as needed
    let salesChart; // Declare the salesChart variable outside the function to access it globally

    // Event listener for month selection
    $('#monthSelect').change(function () {
        const selectedValue = $(this).val();
        const currentYear = new Date().getFullYear();

        if (selectedValue === "yearly") {
            fetchYearlyStats(umkmId);
        } else if (selectedValue) {
            const month = parseInt(selectedValue);
            fetchDailyStats(umkmId, month, currentYear);
        } else {
            resetChart();
        }
    });

    // Function to fetch daily statistics from the API
    function fetchDailyStats(umkmId, month, year) {
        const url = `http://localhost:3000/daily-stats/${umkmId}?month=${month}&year=${year}`; // Use the correct URL

        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                updateStats(data);
                updateChart(data);
            },
            error: function (error) {
                console.error('Error fetching daily stats:', error);
                $('#salesValue').text('Error loading sales data');
                $('#ordersValue').text('Error loading orders data');
            }
        });
    }

    // Function to fetch monthly statistics from the API
    function fetchYearlyStats(umkmId) {
        const url = `http://localhost:3000/monthly-stats/${umkmId}`; // Use the correct URL

        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                updateStats(data);
                updateChart(data, 'yearly'); // Pass 'yearly' for yearly data
            },
            error: function (error) {
                console.error('Error fetching yearly stats:', error);
                $('#salesValue').text('Error loading sales data');
                $('#ordersValue').text('Error loading orders data');
            }
        });
    }

    // Function to update the displayed statistics
    function updateStats(data) {
        const totalSales = data.reduce((sum, record) => sum + record.total_sales, 0);
        const totalOrders = data.reduce((sum, record) => sum + record.total_orders, 0);

        $('#salesValue').text(`$${totalSales.toFixed(2)}`);
        $('#ordersValue').text(totalOrders);
    }

    // Function to update the chart with fetched data
    function updateChart(data, type = 'daily') {
        const labels = type === 'yearly'
            ? data.map(record => monthNames[record.month - 1]) // Use month names for yearly data
            : data.map(record => record.tanggal); // Use dates for daily data
        const salesData = data.map(record => record.total_sales);
        const ordersData = data.map(record => record.total_orders);

        if (salesChart) {
            salesChart.destroy(); // Destroy previous chart instance if it exists
        }

        salesChart = new Chart(document.getElementById('salesChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Sales',
                        data: salesData,
                        backgroundColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                    },
                    {
                        label: 'Total Orders',
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

    // Array of month names for labeling the chart
    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    // Function to reset the chart when no selection is made
    function resetChart() {
        if (salesChart) {
            salesChart.destroy(); // Destroy previous chart instance if it exists
        }
        $('#salesValue').text(''); // Clear sales value
        $('#ordersValue').text(''); // Clear orders value
    }

    // Initial fetch for the current month
    fetchDailyStats(umkmId, new Date().getMonth() + 1, new Date().getFullYear());
});
