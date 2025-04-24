$(document).ready(function () {
    let salesChart;
    const umkmId = parseInt($('meta[name="umkm-id"]').attr('content')) || 0;
    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                      "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    // Initialize year dropdown
    function initYearDropdown() {
        const currentYear = new Date().getFullYear();
        const yearSelect = $('#yearSelect');
        
        for (let year = currentYear; year >= currentYear - 5; year--) {
            yearSelect.append($('<option>', { value: year, text: year }));
        }
        yearSelect.val(currentYear);
    }

    // Initialize and fetch data
    initYearDropdown();
    fetchData();

    // Event listeners
    $('#yearSelect, #monthSelect').change(fetchData);

    // Data fetching functions
    function fetchData() {
        const year = $('#yearSelect').val();
        const month = $('#monthSelect').val();

        if (!year) return resetChart();

        showLoading();
        (month ? fetchDailyStats(umkmId, month, year) : fetchYearlyStats(umkmId, year));
    }

    function fetchDailyStats(umkmId, month, year) {
        $.get(`/daily-stats/${umkmId}?month=${month}&year=${year}`)
            .done(data => processData(data, 'daily'))
            .fail(showError);
    }

    function fetchYearlyStats(umkmId, year) {
        $.get(`/monthly-stats/${umkmId}?year=${year}`)
            .done(data => processData(data, 'yearly'))
            .fail(showError);
    }

    // Data processing
    function processData(data, type) {
        if (data.error) return showError();
        
        updateStats(data);
        updateChart(data, type);
    }

    function updateStats(data) {
        const totalSales = data.reduce((sum, record) => sum + (record.total_sales || 0), 0);
        const totalOrders = data.reduce((sum, record) => sum + (record.total_orders || 0), 0);
        
        $('#salesValue').html(`<span class="text-success">Rp${totalSales.toLocaleString('id-ID')}</span>`);
        $('#ordersValue').html(`<span class="text-primary">${totalOrders.toLocaleString('id-ID')}</span>`);
    }

    // Chart rendering
    function updateChart(data, type) {
        const isYearly = type === 'yearly';
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Prepare data
        const labels = isYearly 
            ? monthNames 
            : data.map(record => record.tanggal);
            
        const salesData = isYearly
            ? Array(12).fill().map((_, i) => {
                const monthData = data.find(d => d.month === i+1);
                return monthData ? monthData.total_sales : 0;
              })
            : data.map(record => record.total_sales || 0);
            
        const ordersData = isYearly
            ? Array(12).fill().map((_, i) => {
                const monthData = data.find(d => d.month === i+1);
                return monthData ? monthData.total_orders : 0;
              })
            : data.map(record => record.total_orders || 0);

        // Destroy existing chart
        if (salesChart) salesChart.destroy();

        // Create new chart with dual axes
        salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Pesanan',
                        data: ordersData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Total Penjualan (Rp)',
                        data: salesData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        type: 'line',
                        yAxisID: 'y1'
                    }
                ]
            },
            options: getChartOptions(isYearly)
        });
    }

    function getChartOptions(isYearly) {
        return {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: getChartTitle(),
                    font: { size: 16 }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            return label + (context.dataset.label === 'Total Penjualan (Rp)' 
                                ? 'Rp' + context.raw.toLocaleString('id-ID') 
                                : context.raw.toLocaleString('id-ID'));
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: { display: true, text: 'Jumlah Pesanan' },
                    beginAtZero: true
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: { display: true, text: 'Total Penjualan (Rp)' },
                    grid: { drawOnChartArea: false },
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp' + (value/1000000).toFixed(1) + 'jt';
                            if (value >= 1000) return 'Rp' + (value/1000).toFixed(1) + 'rb';
                            return 'Rp' + value;
                        }
                    }
                }
            }
        };
    }

    function getChartTitle() {
        const month = $('#monthSelect').val();
        const year = $('#yearSelect').val();
        return month 
            ? `Statistik Harian - ${monthNames[parseInt(month)-1]} ${year}`
            : `Statistik Tahunan - ${year}`;
    }

    function showLoading() {
        $('#salesValue').html('<i class="fas fa-spinner fa-spin"></i> Memuat...');
        $('#ordersValue').html('<i class="fas fa-spinner fa-spin"></i> Memuat...');
    }

    function showError() {
        $('#salesValue').html('<span class="text-danger">Gagal memuat</span>');
        $('#ordersValue').html('<span class="text-danger">Gagal memuat</span>');
        if (salesChart) salesChart.destroy();
    }

    function resetChart() {
        if (salesChart) salesChart.destroy();
        $('#salesValue').text('Pilih tahun');
        $('#ordersValue').text('Pilih tahun');
    }
});