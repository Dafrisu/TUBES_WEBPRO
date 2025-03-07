function toggleSubmenu() {
    var submenu = document.getElementById("submenu");
    var arrowdrop = document.getElementById("dropdownArrow");


    submenu.style.display = submenu.style.display === "block" ? "none" : "block";

    if (submenu.style.display === "none") {
        arrowdrop.style.transform = 'rotate(0deg)';
    } else {
        arrowdrop.style.transform = 'rotate(90deg)';
    }
}


$(document).ready(function () {
    loadPesanan();

    function loadPesanan() {
        $.getJSON('dataPesanan.json', function (data) {
            if (data.dataPesanan && data.dataPesanan.length > 0) {
                displayPesanan(data.dataPesanan);
            }

        }).fail(function () {
            alert("JSON tidak terbaca");
        });
    }

    function displayPesanan(tasks) {
        var ListPesanan = $("#list-Pesanan");
        ListPesanan.empty();
        tasks.forEach(function (item, index) {
            var row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.NamaBarang}</td>
                        <td>${item.KuantitasBarang}</td>
                        <td>${item.harga}</td>
                        <td>
                            <button type="button" class="btn btn-success">Terima</button>
                            <button type="button" class="btn btn-danger">Tolak</button>
                        </td>
                    </tr>
                `;
            ListPesanan.append(row);
        });
    };
});


function loadPesanan() {
    $.getJSON('dataPesanan.json', function (data) {
        if (data.databarang && data.databarang.length > 0) {
            displayTasks(data.tasks);
        }
    });
}

function displayTasks(tasks) {
    var taskList = $("#list-Pesanan");
    taskList.empty();
    tasks.forEach(function (item, index) {
        var row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama}</td>
                        <td>${item.nama}</td>
                        <td>${item.harga}</td>
                        <td><button class="btn btn-primary">Action</button></td>
                    </tr>
                `;
        taskList.append(row);
    });
}