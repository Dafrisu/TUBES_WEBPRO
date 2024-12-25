let allData = []; // Variabel untuk menyimpan semua data barang

$(document).ready(function () {
    // Load barang saat halaman dibuka
    loadBarang();

    // Tombol refresh data
    $("#refreshbutton").click(function () {
        if (allData.length > 0) {
            refreshData();
        }
    });

    // Event handler untuk pills "Semua"
    $("#brg-semua").click(function () {
        tampilkansemuaBarang(allData);
        aktifkanPill(this);
    });

    // Event handler untuk pills "Stok Habis"
    $("#brg-habis").click(function () {
        const stokHabis = allData.filter(barang => barang.stok == 0);
        tampillkanbaranghabis(stokHabis);
        aktifkanPill(this);
    });

    // Fungsi tambah barang
    $("#addbarangbtn").click(function () {
        const nama = $("#id_namabarang").val();
        const harga = $("#id_harga").val();
        const stok = $("#id_stok").val();

        if (!nama || !harga || !stok) {
            alert("Silakan isi semua field.");
            return;
        }

        const newbarang = {
            id: `brg${allData.length + 1}`,
            nama: nama,
            harga: harga,
            stok: parseInt(stok)
        };

        allData.push(newbarang);
        saveDataToLocalStorage(); // Simpan data ke localStorage
        tampilkansemuaBarang(allData); // Tampilkan data terbaru di tabel

        // Reset input setelah ditambahkan
        $("#id_namabarang").val('');
        $("#id_harga").val('');
        $("#id_stok").val('');
    });

    // Fungsi untuk menampilkan semua data yang ada stoknya di tabel
    function tampilkansemuaBarang(data) {
        const produktable = $("#produktable");
        produktable.empty();

        data.forEach((barang, index) => {
            if (barang.stok != 0) {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${barang.id}</td>
                        <td>${barang.nama}</td>
                        <td>${barang.harga}</td>
                        <td>${barang.stok}</td>
                    </tr>`;
                produktable.append(row);
            }
        });
    }

    function tampillkanbaranghabis(data) {
        const produktable = $("#produktable");
        produktable.empty();

        data.forEach((barang, index) => {
            if (barang.stok == 0) {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${barang.id}</td>
                        <td>${barang.nama}</td>
                        <td>${barang.harga}</td>
                        <td>${barang.stok}</td>
                    </tr>`;
                produktable.append(row);
            }
        });
    }

    // Fungsi untuk load data JSON atau dari localStorage
    function loadBarang() {
        const storedData = localStorage.getItem('allData');
        if (storedData) {
            allData = JSON.parse(storedData); // Load dari localStorage jika tersedia
            tampilkansemuaBarang(allData);
        } else {
            $.getJSON('databarang.json', function (data) {
                if (data.databarang && data.databarang.length > 0) {
                    allData = data.databarang;
                    saveDataToLocalStorage(); // Simpan data awal ke localStorage
                    tampilkansemuaBarang(allData);
                } else {
                    alert("Data barang tidak tersedia atau kosong.");
                }
            }).fail(function () {
                alert("Gagal memuat JSON. Periksa path atau format file.");
            });
        }
    }

    // Fungsi untuk menyimpan data ke localStorage
    function saveDataToLocalStorage() {
        localStorage.setItem('allData', JSON.stringify(allData));
    }

    // Function untuk refresh button
    function refreshData() {
        const activePill = $(".nav-link.active").data("filter");

        if (activePill === "semua") {
            tampilkansemuaBarang(allData);
        } else if (activePill === "stokhabis") {
            const stokHabis = allData.filter(barang => barang.stok === 0);
            tampilkansemuaBarang(stokHabis);
        }
    }

    // Fungsi untuk menandai pill yang aktif
    function aktifkanPill(pill) {
        $(".nav-link").removeClass("active");
        $(pill).addClass("active");
    }
});
