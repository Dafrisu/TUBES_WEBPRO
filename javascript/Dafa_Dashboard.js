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
    $("#load-pesanan").click(function () {
        loadTasks();
    });
});


function loadPesanan() {
    $.getJSON('databarang.json', function (data) {
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
                        <td>-</td>
                        <td>${item.harga}</td>
                        <td><button class="btn btn-primary">Action</button></td>
                    </tr>
                `;
        taskList.append(row);
    });
}