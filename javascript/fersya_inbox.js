function toggleSubmenu() {
    var submenu = document.getElementById("submenu");
    submenu.style.display = submenu.style.display === "block" ? "none" : "block";
}

function showPesananMasuk() {
    document.getElementById('prioritasPesananTable').style.display = 'none';
    document.getElementById('pesananMasukTable').style.display = 'block';
    document.getElementById("pemasaranContent").style.display = 'none';
    document.getElementById('pilihTab').style.display = 'none';
}

function showPesananPrioritas() {
    document.getElementById('pesananMasukTable').style.display = 'none';
    document.getElementById('prioritasPesananTable').style.display = 'block';
    document.getElementById("pemasaranContent").style.display = "none";
    document.getElementById('pilihTab').style.display = 'none';
}

function showPemasaran() {
    document.getElementById("pemasaranContent").style.display = "block";
    document.getElementById("pesananMasukTable").style.display = "none";
    document.getElementById("prioritasPesananTable").style.display = "none";
    document.getElementById('pilihTab').style.display = 'none';
}