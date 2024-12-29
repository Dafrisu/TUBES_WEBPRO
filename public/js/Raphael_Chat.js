// Raphael_Chat.js
// Base API URL
const API_BASE_URL = "https://umkmapi.azurewebsites.net/message";

// Function to navigate to the chat page
function navigateToChat(customerId) {
    window.location.href = `{{ route('umkm.message') }}?customerId=${customerId}`;
}

// Load messages when the page is loaded
window.onload = function () {
    loadMessages();
};

// Function to load chat messages
async function loadMessages() {
    const urlParams = new URLSearchParams(window.location.search);
    const customerId = urlParams.get("customerId");

    if (!customerId) {
        console.error("No customerId in the URL");
        return;
    }

    const userNameElement = document.getElementById("userName");
    if (userNameElement) {
        userNameElement.innerText = `Customer ID: ${customerId}`;
    }

    try {
        const response = await fetch(`/umkm/message?customerId=${customerId}`); // Updated endpoint

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const customerChat = await response.json();
        const chatWindow = document.getElementById("chatWindow");
        chatWindow.innerHTML = ""; // Clear any previous messages

        customerChat.forEach((chatItem) => {
            const messageHTML = `
                <div class="message ${
                    chatItem.sender_type === "self" ? "right" : "left"
                }">
                    <img src="/images/${
                        chatItem.sender_type === "self" ? "umkm" : "customer"
                    }_Profilepic.png" alt="User Avatar" class="avatar">
                    <div class="message-bubble">
                        <p>${chatItem.message}</p>
                        <div class="message-time">${new Date(
                            chatItem.sent_at
                        ).toLocaleTimeString("en-US", {
                            hour: "2-digit",
                            minute: "2-digit",
                            second: "2-digit",
                            hour12: false,
                        })}</div>
                    </div>
                </div>
            `;
            chatWindow.insertAdjacentHTML("beforeend", messageHTML);
        });

        chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll to the bottom
    } catch (error) {
        console.error("Error loading chat:", error);
    }
}

// Function to send a message
async function sendMessage() {
    console.log("Send message triggered");
    const messageInput = document.getElementById("messageInput");
    const message = messageInput.value.trim();
    const urlParams = new URLSearchParams(window.location.search);
    const customerId = urlParams.get("customerId");

    if (message && customerId) {
        try {
            const receiverId = "receiverId"; // Set your dynamic receiverId here
            const receiverType = "Pembeli"; // Set the dynamic receiver type here

            const response = await fetch("/umkm/message/send", {
                method: "POST", // Make sure the method is POST
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    message,
                    sender_id: customerId, // Dynamic customerId
                    sender_type: "UMKM", // Sender type
                    receiver_id: receiverId, // Dynamic receiverId
                    receiver_type: receiverType, // Dynamic receiverType
                }),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const newMessage = await response.json();

            const chatWindow = document.getElementById("chatWindow");
            const messageHTML = `
                <div class="message right">
                    <img src="/images/Profilepic.png" alt="User Avatar" class="avatar">
                    <div class="message-bubble">
                        <p>${newMessage.message}</p>
                        <div class="message-time">${new Date(
                            newMessage.sent_at
                        ).toLocaleTimeString("en-US", {
                            hour: "2-digit",
                            minute: "2-digit",
                            second: "2-digit",
                            hour12: false,
                        })}</div>
                    </div>
                </div>
            `;
            chatWindow.insertAdjacentHTML("beforeend", messageHTML);
            messageInput.value = ""; // Clear input
            chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll to the bottom
        } catch (error) {
            console.error("Error sending message:", error);
        }
    }
}

document
    .getElementById("sendButton")
    .addEventListener("click", async function () {
        const messageInput = document.getElementById("messageInput");
        const message = messageInput.value.trim();
        const customerId = document.getElementById("customerId").value;

        if (message && customerId) {
            try {
                const receiverId = "receiver_Id"; // Gantilah dengan receiverId yang sesuai
                const receiverType = "Pembeli"; // Gantilah dengan receiverType yang sesuai

                const response = await fetch("/umkm/message/send", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content, // CSRF token
                    },
                    body: JSON.stringify({
                        message,
                        sender_id: customerId, // ID pengirim
                        sender_type: "UMKM", // Tipe pengirim
                        receiver_id: receiverId, // ID penerima
                        receiver_type: receiverType, // Tipe penerima
                    }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const newMessage = await response.json();

                const chatWindow = document.getElementById("chatWindow");
                const messageHTML = `
                <div class="message right">
                    <img src="/images/Profilepic.png" alt="User Avatar" class="avatar">
                    <div class="message-bubble">
                        <p>${newMessage.message}</p>
                        <div class="message-time">${newMessage.sent_at}</div>
                    </div>
                </div>
            `;
                chatWindow.insertAdjacentHTML("beforeend", messageHTML);
                messageInput.value = ""; // Kosongkan input
                chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll ke bawah
            } catch (error) {
                console.error("Error sending message:", error);
            }
        }
    });

// Add event listener to "Enter" key to send the message
document
    .getElementById("messageInput")
    .addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            document.getElementById("sendButton").click();
        }
    });

// Add event listener to back button
document.getElementById("backButton").addEventListener("click", () => {
    window.location.href = `/message`;
});
