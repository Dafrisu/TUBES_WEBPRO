const input = document.getElementById("searchInput");
const resultContainer = document.getElementById("search-result-container");
const semuaContainer = document.getElementById("semua");
const makananContainer = document.getElementById("makanan");
const minumanContainer = document.getElementById("minuman");

let typingTimer;
const delay = 300;

// Fungsi untuk menampilkan tab sesuai id
function showTabContent(tabId) {
    semuaContainer.style.display = "none";
    makananContainer.style.display = "none";
    minumanContainer.style.display = "none";
    resultContainer.style.display = "none";

    if (tabId === "semua") {
        semuaContainer.style.display = "block";
    } else if (tabId === "makanan") {
        makananContainer.style.display = "block";
    } else if (tabId === "minuman") {
        minumanContainer.style.display = "block";
    }
}

input.addEventListener("input", () => {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
        const keyword = input.value.trim();
        let activeTab = document.querySelector('.tab-pane.active');

        fetch(`/searchproduk?search=${encodeURIComponent(keyword)}`)
            .then(res => res.text())
            .then(html => {
                resultContainer.innerHTML = html;

                if (keyword === "") {
                    if (activeTab) showTabContent(activeTab.id);
                } else {
                    semuaContainer.style.display = "none";
                    makananContainer.style.display = "none";
                    minumanContainer.style.display = "none";
                    resultContainer.style.display = "block";
                }
            })
            .catch(err => {
                console.error("Search error:", err);
            });
    }, delay);
});

// Event saat tab diklik (gunakan jQuery karena Bootstrap pakai ini)
document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', (e) => {
        const targetId = new URL(e.target.href).hash.substring(1); // ambil ID tab
        const keyword = input.value.trim();

        if (keyword === "") {
            showTabContent(targetId);
        } else {
            semuaContainer.style.display = "none";
            makananContainer.style.display = "none";
            minumanContainer.style.display = "none";
            resultContainer.style.display = "block";
        }
    });
});
