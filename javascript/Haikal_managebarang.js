let allData = []; // Variabel untuk menyimpan semua data barang

        // untuk tabel func
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
                tampilkanBarang(allData);
                aktifkanPill(this);
            });

            // Event handler untuk pills "Stok Habis"
            $("#brg-habis").click(function () {
                const stokHabis = allData.filter(barang => barang.stok == 0);
                tampilkanBarang(stokHabis);
                aktifkanPill(this);
            });

            $("#addbarangbtn").click(function(){
                const nama =  $("#id_namabarang").val();
                const harga = parseFloat($("#id_harga").val());
                const stok = parseInt($("is_stok").val());

                const newbarang = {
                    "id" :  $(allData.length +1),
                    "nama": nama,
                    "harga": harga,
                    "stok": stok
                }

                allData.push(newbarang);
            });

            // Fungsi untuk menampilkan data di tabel
            function tampilkanBarang(data) {
                const produktable = $("#produktable");
                produktable.empty(); 

                data.forEach((barang, index) => {
                    const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${barang.id}</td>
                <td>${barang.nama}</td>
                <td>${barang.harga}</td>
                <td>${barang.stok}</td>
            </tr>`;
                    produktable.append(row);
                });
            }

            // Fungsi untuk load data JSON
            function loadBarang() {
                $.getJSON('databarang.json', function (data) {
                    if (data.databarang && data.databarang.length > 0) {
                        allData = data.databarang; // Simpan semua data
                        tampilkanBarang(allData); // Tampilkan data
                    } else {
                        alert("Data barang tidak tersedia atau kosong.");
                    }
                }).fail(function () {
                    alert("Gagal memuat JSON. Periksa path atau format file.");
                });
            }

            // function untuk refresh button
            function refreshData() {
                const activePill = $(".nav-link.active").data("filter"); // Cek pill aktif

                if (activePill === "semua") {
                    tampilkanBarang(allData); // Tampilkan semua barang
                } else if (activePill === "stokhabis") {
                    const stokHabis = allData.filter(barang => barang.stok === 0);
                    tampilkanBarang(stokHabis); // Tampilkan barang stok habis
                }
            }

            // Fungsi untuk menandai pill yang aktif
            function aktifkanPill(pill) {
                $(".nav-link").removeClass("active"); // Hapus class 'active' dari semua pill
                $(pill).addClass("active"); // Tambahkan class 'active' ke pill yang diklik
            }
        });