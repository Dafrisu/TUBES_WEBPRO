// Variabel global untuk menyimpan data
let allData = [];

document.addEventListener("DOMContentLoaded", function () {
    // Load data barang saat halaman pertama kali dibuka
    loadBarang();

    // Tombol refresh data
    document.getElementById("refreshbutton").addEventListener("click", function () {
        if (allData.length > 0) {
            refreshData();
        }
    });

    // Event handler untuk pills "Semua"
    document.getElementById("brg-semua").addEventListener("click", function () {
        tampilkansemuaBarang(allData);
        aktifkanPill(this);
    });

    // Event handler untuk pills "Stok Habis"
    document.getElementById("brg-habis").addEventListener("click", function () {
        const stokHabis = allData.filter(barang => barang.stok === 0);
        tampillkanbaranghabis(stokHabis);
        aktifkanPill(this);
    });

    // Fungsi untuk load data menggunakan fetch
    function loadBarang() {
        fetch('https://umkmapi-production.up.railway.app/produk')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Response Data:", data); // Debug: Periksa data yang diterima

                if (Array.isArray(data) && data.length > 0) {
                    allData = data; // Simpan data dari respons API
                    tampilkansemuaBarang(allData); // Tampilkan data di tabel
                } else {
                    alert("Data barang tidak tersedia atau kosong.");
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                alert("Gagal memuat data. Periksa koneksi atau backend.");
            });
    }


    // Fungsi untuk menampilkan semua barang
    function tampilkansemuaBarang(data) {
        const produktable = document.getElementById("produktable");
        produktable.innerHTML = ""; // Kosongkan tabel

        data.forEach((barang, index) => {
            if (barang.stok != 0) {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${barang.id}</td>
                        <td>${barang.nama_barang}</td>
                        <td>${barang.harga.toLocaleString()}</td>
                        <td>${barang.stok}</td>
                        <td>${barang.berat} kg</td>
                        <td>
                            <a href="/umkm/viewupdate/${barang.id}">
                                <button type="button" class="btn btn-warning">Edit</button>
                            </a>
                            <form action="/umkm/deletebarang/${barang.id}" method="post" style="display:inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>`;
                produktable.insertAdjacentHTML('beforeend', row);
            }
        });
    }

    // Fungsi untuk menampilkan barang habis stok
    function tampillkanbaranghabis(data) {
        const produktable = document.getElementById("produktable");
        produktable.innerHTML = ""; // Kosongkan tabel

        data.forEach((barang, index) => {
            if (barang.stok === 0) {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${barang.id}</td>
                        <td>${barang.nama_barang}</td>
                        <td>${barang.harga.toLocaleString()}</td>
                        <td>${barang.stok}</td>
                        <td>${barang.berat} kg</td>
                        <td>
                            <a href="/umkm/viewupdate/${barang.id}">
                                <button type="button" class="btn btn-warning">Edit</button>
                            </a>
                            <form action="/umkm/deletebarang/${barang.id}" method="post" style="display:inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>`;
                produktable.insertAdjacentHTML('beforeend', row);
            }
        });
    }

    // Fungsi untuk refresh data
    function refreshData() {
        const activePill = document.querySelector(".nav-link.active").dataset.filter;

        if (activePill === "semua") {
            tampilkansemuaBarang(allData);
        } else if (activePill === "stokhabis") {
            const stokHabis = allData.filter(barang => barang.stok === 0);
            tampillkanbaranghabis(stokHabis);
        }
    }

    // Fungsi untuk menandai pill yang aktif
    function aktifkanPill(pill) {
        document.querySelectorAll(".nav-link").forEach(link => link.classList.remove("active"));
        pill.classList.add("active");
    }
});
