// Raphael_Message.js
// Convert time string to Date object for proper sorting
function timeToDate(timeStr) {
    const today = new Date();
    const [time, period] = timeStr.split(" ");
    const [hours, minutes] = time.split(":");
    let hour = parseInt(hours);

    if (period === "PM" && hour !== 12) {
        hour += 12;
    } else if (period === "AM" && hour === 12) {
        hour = 0;
    }

    today.setHours(hour, parseInt(minutes), 0);
    return today;
}

let currentMessages = [];

// Fetch messages dynamically from the Laravel backend
function showChatSection(section) {
    const filtersBar = document.getElementById("filtersBar");
    const exampleMessages = document.getElementById("exampleMessages");
    const emptyMessage = document.getElementById("emptyMessage");

    filtersBar.style.display = "block";
    exampleMessages.innerHTML = ""; // Clear previous content
    emptyMessage.style.display = "none"; // Hide empty message initially

    fetch(`/umkm/messages?section=${section}`)
        .then((response) => response.json())
        .then((data) => {
            currentMessages = data.messages; // Update messages based on section
            displayMessages(currentMessages);
        })
        .catch((error) => {
            console.error("Error loading messages:", error);
            alert("Gagal memuat pesan. Pastikan server berjalan dengan baik.");
        });
    sortDropdown.selectedIndex = 0;
}

function searchMessages(event) {
    if (event.key === "Enter") {
        event.target.blur(); // Blur the input field when Enter is pressed
        return;
    }
    const query = event.target.value.toLowerCase(); // Get the search query in lowercase
    const filteredMessages = currentMessages.filter(
        (msg) =>
            msg.name.toLowerCase().includes(query) || // Filter by name
            msg.message.toLowerCase().includes(query) // Filter by message
    );
    displayMessages(filteredMessages); // Display the filtered messages
}

function sortMessages(event) {
    const sortBy = event.target.value; // Get the selected sort option
    if (!sortBy) return;

    // Sort the messages based on time
    const sortedMessages = [...currentMessages].sort((a, b) => {
        const dateA = timeToDate(a.time);
        const dateB = timeToDate(b.time);
        return sortBy === "newest" ? dateB - dateA : dateA - dateB;
    });

    displayMessages(sortedMessages); // Display the sorted messages
}

function displayMessages(messageList) {
    const exampleMessages = document.getElementById("exampleMessages");
    const emptyMessage = document.getElementById("emptyMessage");

    exampleMessages.innerHTML = "";

    if (messageList.length === 0) {
        emptyMessage.style.display = "block"; // Show "No messages" if the list is empty
    } else {
        emptyMessage.style.display = "none"; // Hide "No messages" if there are messages
        messageList.forEach((msg) => {
            exampleMessages.innerHTML += `
                <div class="card mb-2" style="width: 100%;" onclick="navigateToChat('${msg.name}', '${msg.message}')">
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

function loadChatMessages(userName) {
    const umkmID = 123; // ID UMKM Anda
    fetch(`/getmessageumkm/${umkmID}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Ambil semua pesan dari respons
                const allMessages = [
                    ...data.messages[""],
                    ...data.messages.unread,
                ];
                // Filter pesan berdasarkan nama pengguna
                currentMessages = allMessages.filter(
                    (msg) => msg.name === userName
                );

                if (currentMessages.length > 0) {
                    displayChat(currentMessages);
                } else {
                    document.getElementById("chatWindow").innerHTML =
                        "<p>No messages found for this user.</p>";
                }
            } else {
                console.error("Error:", data.error);
                alert(data.error);
            }
        })
        .catch((error) => {
            console.error("Error loading messages:", error);
        });
}

// Scroll to bottom on page load
window.onload = function () {
    chatWindow.scrollTop = chatWindow.scrollHeight;
};

document.getElementById("backButton").addEventListener("click", goBack);

function goBackChat() {
    window.history.back();
}

// Modify `navigateToChat` to use Laravel route
// function navigateToChat(name, message) {
//     window.location.href = `/umkm/chat?name=${encodeURIComponent(
//         name
//     )}&message=${encodeURIComponent(message)}`;
// }

// Function to render chat cards for each buyer
function renderChatCards(messages) {
    const chatInterface = document.getElementById("chatInterface");
    chatInterface.innerHTML = ""; // Clear the chat interface first

    if (messages.length === 0) {
        chatInterface.innerHTML = '<p class="text-center">Tidak ada pesan</p>';
    } else {
        // Group messages by buyer ID
        const groupedMessages = messages.reduce((acc, message) => {
            const buyerId = message.id_pembeli;
            if (!acc[buyerId]) {
                acc[buyerId] = [];
            }
            acc[buyerId].push(message);
            return acc;
        }, {});

        // Loop through each buyer's messages
        Object.keys(groupedMessages).forEach((buyerId) => {
            const buyerMessages = groupedMessages[buyerId];

            // Create a card for the buyer
            const card = document.createElement("div");
            card.classList.add("card", "mb-3");

            // Add buyer info to the card (assuming you have a way to get buyer's name or other details)
            const buyerInfo = document.createElement("div");
            buyerInfo.classList.add("card-header");
            buyerInfo.innerHTML = `Pembeli ${buyerId}`; // You can replace with actual buyer name if available
            card.appendChild(buyerInfo);

            // Add messages to the card
            const cardBody = document.createElement("div");
            cardBody.classList.add("card-body");
            buyerMessages.forEach((message) => {
                const messageElement = document.createElement("p");
                messageElement.classList.add("card-text");
                messageElement.innerHTML = `${message.message} <small class="text-muted">- ${message.sent_at}</small>`;
                cardBody.appendChild(messageElement);
            });

            card.appendChild(cardBody);
            chatInterface.appendChild(card);
        });
    }
}

// Example data - you will get this from your backend
const messages = [
    {
        sent_at: "12:30:00",
        id_chat: 2,
        message: "Hello, this is a test message.",
        is_read: false,
        id_umkm: 1,
        id_pembeli: 1,
        id_kurir: null,
    },
    {
        sent_at: "12:35:00",
        id_chat: 3,
        message: "How can I help you?",
        is_read: false,
        id_umkm: 1,
        id_pembeli: 2,
        id_kurir: null,
    },
    {
        sent_at: "12:40:00",
        id_chat: 4,
        message: "Can you help me with my order?",
        is_read: false,
        id_umkm: 1,
        id_pembeli: 1,
        id_kurir: null,
    },
];

// Call the function to render chat cards
renderChatCards(messages);

function toggledropdown() {
    const submenu = document.getElementById("submenu");
    const sidebarItem = submenu.parentElement;

    submenu.classList.toggle("collapsed");
    sidebarItem.classList.toggle("active");
}
