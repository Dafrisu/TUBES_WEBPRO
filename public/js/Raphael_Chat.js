// Raphael_Chat.js
// Base API URL
const API_BASE_URL = "https://umkmapi-production.up.railway.app/message";

// Function to navigate to the chat page
function navigateToChat() {
    window.location.href = `{{ route('messagepage') }}`;
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

        // Sort messages by 'sent_at' in ascending order (oldest first)
        customerChat.sort((a, b) => a.id_chat - b.id_chat);

        const chatWindow = document.getElementById("chatWindow");
        chatWindow.innerHTML = ""; // Clear any previous messages

        customerChat.forEach((chatItem) => {
            const messageHTML = `
                <div class="message ${chatItem.sender_type === "self" ? "right" : "left"
                }">
                    <img src="/images/${chatItem.sender_type === "self" ? "umkm" : "customer"
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
            const receiverId = "receiver_Id"; // Set receiverId dynamically
            const receiverType = "Pembeli"; // Set receiverType dynamically

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

// Event listener for the send button
document.getElementById("sendButton").addEventListener("click", sendMessage);

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
