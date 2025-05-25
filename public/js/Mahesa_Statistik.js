$(document).ready(function() {
	let salesChart;
	const umkmId = parseInt($('meta[name="umkm-id"]').attr('content')) || 0;
	const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
		"Juli", "Agustus", "September", "Oktober", "November", "Desember"
	];

	// Initialize year dropdown
	function initYearDropdown() {
		const currentYear = new Date().getFullYear();
		const yearSelect = $('#yearSelect');

		for (let year = currentYear; year >= currentYear - 5; year--) {
			yearSelect.append($('<option>', {
				value: year,
				text: year
			}));
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
		updateProductStats(data, type);
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

		const labels = isYearly ?
			monthNames :
			data.map(record => record.tanggal);

		const salesData = isYearly ?
			Array(12).fill().map((_, i) => {
				const monthData = data.find(d => d.month === i + 1);
				return monthData ? monthData.total_sales : 0;
			}) :
			data.map(record => record.total_sales || 0);

		const ordersData = isYearly ?
			Array(12).fill().map((_, i) => {
				const monthData = data.find(d => d.month === i + 1);
				return monthData ? monthData.total_orders : 0;
			}) :
			data.map(record => record.total_orders || 0);

		if (salesChart) salesChart.destroy();

		salesChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
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
					font: {
						size: 16
					}
				},
				tooltip: {
					callbacks: {
						label: function(context) {
							let label = context.dataset.label || '';
							if (label) label += ': ';
							return label + (context.dataset.label === 'Total Penjualan (Rp)' ?
								'Rp' + context.raw.toLocaleString('id-ID') :
								context.raw.toLocaleString('id-ID'));
						}
					}
				}
			},
			scales: {
				y: {
					type: 'linear',
					display: true,
					position: 'left',
					title: {
						display: true,
						text: 'Jumlah Pesanan'
					},
					beginAtZero: true
				},
				y1: {
					type: 'linear',
					display: true,
					position: 'right',
					title: {
						display: true,
						text: 'Total Penjualan (Rp)'
					},
					grid: {
						drawOnChartArea: false
					},
					beginAtZero: true,
					ticks: {
						callback: function(value) {
							if (value >= 1000000) return 'Rp' + (value / 1000000).toFixed(1) + 'jt';
							if (value >= 1000) return 'Rp' + (value / 1000).toFixed(1) + 'rb';
							return 'Rp' + value;
						}
					}
				}
			}
		};
	}

	// Product stats functions
	function updateProductStats(data, type) {
		const productContainer = $('#productStats');
		productContainer.empty();

		if (!data || data.length === 0) {
			productContainer.html('<div class="alert alert-info">Tidak ada data produk untuk periode ini</div>');
			return;
		}

		const productMap = {};
		data.forEach(record => {
			record.products.forEach(product => {
				if (!productMap[product.id_produk]) {
					productMap[product.id_produk] = {
						tanggal: product.tanggal, // Use original tanggal
						name: product.Nama_Barang,
						total_sales: 0,
						total_quantity: 0,
						price: product.Harga
					};
				}
				productMap[product.id_produk].total_sales += product.total_sales;
				productMap[product.id_produk].total_quantity += product.quantity;
			});
		});

		const period = type === 'yearly' ?
			$('#yearSelect').val() :
			`${monthNames[parseInt($('#monthSelect').val())-1]} ${$('#yearSelect').val()}`;

		const exportData = Object.values(productMap);
		const totalSales = exportData.reduce((sum, p) => sum + p.total_sales, 0);
		const totalQuantity = exportData.reduce((sum, p) => sum + p.total_quantity, 0);

		let html = `
        <div class="card shadow-sm mt-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0 fw-bold">Detail Produk Terjual - ${period}</h5>
                <div>
                    <button id="exportBtn" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="productTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="35%">Tanggal</th>
                                <th width="35%">Nama Produk</th>
                                <th class="text-end" width="18%">Harga Satuan</th>
                                <th class="text-end" width="18%">Jumlah Terjual</th>
                                <th class="text-end" width="21%">Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>`;

		exportData.forEach((product) => {
			html += `
                <tr>
                    <td class="text-center">${product.tanggal}</td>
                    <td><strong>${product.name}</strong></td>
                    <td class="text-end">Rp${product.price.toLocaleString('id-ID')}</td>
                    <td class="text-end">${product.total_quantity}</td>
                    <td class="text-end"><strong>Rp${product.total_sales.toLocaleString('id-ID')}</strong></td>
                </tr>`;
		});

		html += `
                    </tbody>
                    <tfoot class="table-light">
                        <tr class="fw-bold">
                            <th colspan="2" class="text-end">Total</th>
                            <th class="text-end">${exportData.length} Produk</th>
                            <th class="text-end">${totalQuantity}</th>
                            <th class="text-end">Rp${totalSales.toLocaleString('id-ID')}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>`;

		productContainer.html(html);
		$('#exportBtn').click(() => exportToExcel(exportData, period));
	}

	function exportToExcel(data, period) {
		if (typeof XLSX === 'undefined') {
			alert('Excel export library not loaded. Please add the XLSX library to your page.');
			return;
		}

		const worksheetData = [
			['Detail Produk Terjual - ' + period],
			[''],
			['Tanggal', 'Nama Produk', 'Harga Satuan', 'Jumlah Terjual', 'Total Penjualan']
		];

		data.forEach(item => {
			worksheetData.push([
				item.tanggal,
				item.name,
				item.price,
				item.total_quantity,
				item.total_sales
			]);
		});

		const totalSales = data.reduce((sum, item) => sum + item.total_sales, 0);
		const totalQuantity = data.reduce((sum, item) => sum + item.total_quantity, 0);

		worksheetData.push([]);
		worksheetData.push([
			'Total',
			data.length + ' Produk',
			'',
			totalQuantity,
			totalSales
		]);

		const workbook = XLSX.utils.book_new();
		const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);

		worksheet['!cols'] = [{
				width: 30
			}, // Tanggal
			{
				width: 30
			}, // Nama Produk
			{
				width: 15
			}, // Harga Satuan
			{
				width: 15
			}, // Jumlah Terjual
			{
				width: 20
			} // Total Penjualan
		];

		XLSX.utils.book_append_sheet(workbook, worksheet, 'Produk Terjual');
		const fileName = `produk_terjual_${period.replace(/\s+/g, '_')}.xlsx`;
		XLSX.writeFile(workbook, fileName);
	}

	function getChartTitle() {
		const month = $('#monthSelect').val();
		const year = $('#yearSelect').val();
		return month ?
			`Statistik Harian - ${monthNames[parseInt(month)-1]} ${year}` :
			`Statistik Tahunan - ${year}`;
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
		$('#productStats').empty();
	}
});