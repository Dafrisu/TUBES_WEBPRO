// Convert time string to Date object for proper sorting
function timeToDate(timeStr) {
    const today = new Date();
    const [time, period] = timeStr.split(' ');
    const [hours, minutes] = time.split(':');
    let hour = parseInt(hours);
    
    if (period === 'PM' && hour !== 12) {
        hour += 12;
    } else if (period === 'AM' && hour === 12) {
        hour = 0;
    }
    
    today.setHours(hour, parseInt(minutes), 0);
    return today;
}

const messages = {
    open: [
        { name: "Customer A", message: "Kapan barang saya dikirim?", time: "10:00 AM" },
        { name: "Customer B", message: "Apakah produk ini tersedia?", time: "10:15 AM" },
        { name: "Customer C", message: "Saya ingin mengubah alamat pengiriman.", time: "10:30 AM" },
        { name: "Customer D", message: "Bisa tolong update status pesanan saya?", time: "10:45 AM" },
        { name: "Customer E", message: "Ada promo untuk bulan ini?", time: "11:00 AM" }
    ],
    unread: [
        { name: "Customer F", message: "Bagaimana cara mengklaim garansi?", time: "11:15 AM" },
        { name: "Customer G", message: "Saya tertarik dengan produk ini, bisa minta detailnya?", time: "11:30 AM" },
        { name: "Customer H", message: "Kapan pesanan saya akan tiba?", time: "11:45 AM" },
        { name: "Customer I", message: "Apakah ada diskon untuk pembelian grosir?", time: "12:00 PM" },
        { name: "Customer J", message: "Bisa tolong kirim faktur pembelian?", time: "12:15 PM" }
    ],
    unreplied: [
        { name: "Customer K", message: "Saya ingin mengajukan retur barang.", time: "12:30 PM" },
        { name: "Customer L", message: "Apakah produk ini asli?", time: "12:45 PM" },
        { name: "Customer M", message: "Bisa bantu saya melacak pesanan?", time: "1:00 PM" },
        { name: "Customer N", message: "Bagaimana cara pembayaran?", time: "1:15 PM" },
        { name: "Customer O", message: "Apakah ada opsi pengiriman ekspres?", time: "1:30 PM" }
    ]
};

let currentMessages = [];

function showChatSection(section) {
    const filtersBar = document.getElementById('filtersBar');
    const chatInterface = document.getElementById('chatInterface');
    const exampleMessages = document.getElementById('exampleMessages');
    const emptyMessage = document.getElementById('emptyMessage');

    filtersBar.style.display = 'block';
    chatInterface.style.display = 'none';
    exampleMessages.style.display = 'block';
    
    currentMessages = [...messages[section]];
    displayMessages(currentMessages);
}

function searchMessages(event) {
    if (event.key === 'Enter') {
        event.target.blur();
        return;
    }
    const query = event.target.value.toLowerCase();
    const filteredMessages = currentMessages.filter(msg => 
        msg.name.toLowerCase().includes(query) || 
        msg.message.toLowerCase().includes(query)
    );
    displayMessages(filteredMessages);
}

function sortMessages(event) {
    const sortBy = event.target.value;
    if (!sortBy) return;

    const sortedMessages = [...currentMessages].sort((a, b) => {
        const dateA = timeToDate(a.time);
        const dateB = timeToDate(b.time);
        return sortBy === 'newest' ? dateB - dateA : dateA - dateB;
    });
    
    displayMessages(sortedMessages);
}

function displayMessages(messageList) {
    const exampleMessages = document.getElementById('exampleMessages');
    const emptyMessage = document.getElementById('emptyMessage');
    
    exampleMessages.innerHTML = "";
    
    if (messageList.length === 0) {
        emptyMessage.style.display = 'block';
    } else {
        emptyMessage.style.display = 'none';
        messageList.forEach(msg => {
            exampleMessages.innerHTML += `
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">${msg.name}</h5>
                        <p class="card-text">${msg.message}</p>
                        <p class="text-muted">${msg.time}</p>
                    </div>
                </div>
            `;
        });
    }
}

const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});