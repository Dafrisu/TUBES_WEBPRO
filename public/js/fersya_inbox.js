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
    loadCampaigns();
}

// function loadCampaigns() {
//     fetch('/json/dataPemasaran.json') 
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(`HTTP error! status: ${response.status}`);
//             }
//             return response.json();
//         })
//         .then(campaigns => {
//             const container = document.getElementById("campaignContainer");
//             container.innerHTML = ""; 
//             campaigns.forEach((campaign) => {
//                 const card = `
//                     <div class="col-md-4">
//                         <div class="card mb-3" style="max-width: 540px; min-width: fit-content;">
//                             <div class="row g-0">
//                                 <div class="col-md-4">
//                                     <img src="${campaign.imageUrl}" class="img-fluid rounded-start" alt="${campaign.title}">
//                                 </div>
//                                 <div class="col-md-8">
//                                     <div class="card-body">
//                                         <h5 class="card-title">${campaign.title}</h5>
//                                         <p class="card-text">${campaign.description}</p>
//                                         <p class="card-text"><small class="text-body-secondary">Last updated ${campaign.lastUpdated}</small></p>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 `;
//                 container.insertAdjacentHTML("beforeend", card);
//             });
//         })
//         .catch(error => console.error('Error loading campaigns:', error));
// }

document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll(".prioritas-checkbox");

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function(event) {
            const orderId = event.target.dataset.id; 
            const isChecked = event.target.checked; 
            const row = document.getElementById(`row-${orderId}`);
            const tbody = row.closest("tbody");

            if (isChecked) {
                
                tbody.insertBefore(row, tbody.firstChild); 
            } else {
                
                const originalPosition = Array.from(tbody.rows).findIndex(r => r.id === `row-${orderId}`);
                tbody.appendChild(row); 
            }
        });
    });
});
