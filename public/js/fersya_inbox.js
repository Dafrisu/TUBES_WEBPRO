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

function loadCampaigns() {
    fetch('dataPemasaran.json')
        .then(response => response.json())
        .then(campaigns => {
            const container = document.getElementById("campaignContainer");
            container.innerHTML = ""; 
            campaigns.forEach((campaign) => {
                const card = `
                    <div class="col-md-4">
                        <div class="card mb-3" style="max-width: 540px; min-width: fit-content;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="${campaign.imageUrl}" class="img-fluid rounded-start" alt="${campaign.title}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">${campaign.title}</h5>
                                        <p class="card-text">${campaign.description}</p>
                                        <p class="card-text"><small class="text-body-secondary">Last updated ${campaign.lastUpdated}</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML("beforeend", card);
            });
        })
        .catch(error => console.error('Error loading campaigns:', error));
}


function showPemasaran() {
    document.getElementById("pemasaranContent").style.display = "block";
    loadCampaigns();
}
// function showAktivitas() {
//     document.getElementById("aktivitas").style.display = "block";
//     document.getElementById("pemasaranContent").style.display = "none";
//     document.getElementById("pesananMasukTable").style.display = "none";
//     document.getElementById("prioritasPesananTable").style.display = "none";
//     document.getElementById('pilihTab').style.display = 'none';
// }