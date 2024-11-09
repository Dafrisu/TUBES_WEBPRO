$(document).ready(function() {
    // Fetch the JSON file (ensure the correct path to the JSON file)
    $.getJSON("javascript/Mahesa_Statistik.json", function(data) {
        updateDashboard(data);
    });
});

function updateDashboard(data) {
    updateStatsCards(data.stats, data.chart);
    initializeChart(data.chart);
}

function updateStatsCards(stats, chartData) {
    const totalSales = chartData.datasets.sales.data.reduce((sum, value) => sum + value, 0);
    const totalOrders = chartData.datasets.orders.data.reduce((sum, value) => sum + value, 0);

    $('#salesValue').text(`Rp ${totalSales.toLocaleString()}`);
    $('#salesChange').text(`${stats.sales.change}% from last month`);

    $('#ordersValue').text(totalOrders.toLocaleString());
    $('#ordersChange').text(`${stats.orders.change}% from last month`);

    $('#visitorsValue').text(stats.visitors.value.toLocaleString());
    $('#visitorsChange').text(`${stats.visitors.change}% from last month`);

    $('#viewsValue').text(stats.views.value.toLocaleString());
    $('#viewsChange').text(`${stats.views.change}% from last month`);
}

function initializeChart(chartData) {
    new Chart('chart', {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Sales',
                    data: chartData.datasets.sales.data,
                    borderColor: chartData.datasets.sales.borderColor,
                    backgroundColor: chartData.datasets.sales.backgroundColor,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y-sales',
                },
                {
                    label: 'Orders',
                    data: chartData.datasets.orders.data,
                    borderColor: chartData.datasets.orders.borderColor,
                    backgroundColor: chartData.datasets.orders.backgroundColor,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y-orders',
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 10
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#000',
                    bodyColor: '#666',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    padding: 10,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.datasetIndex === 0) {
                                label += 'Rp ' + context.parsed.y.toLocaleString();
                            } else {
                                label += context.parsed.y + ' orders';
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                'y-sales': {
                    type: 'linear',
                    position: 'left',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Sales (Rp)'
                    },
                    grid: {
                        borderDash: [2, 2]
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                },
                'y-orders': {
                    type: 'linear',
                    position: 'right',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Orders'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
