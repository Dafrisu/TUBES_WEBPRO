// Raphael_Chat.js
// Function to navigate to the chat page
function navigateToChat(customerId) {
    window.location.href = `Raphael_message_chatPage.blade.php?customerId=${customerId}`;
}

// Add event listener to each customer element
document.querySelectorAll(".customer").forEach((customerElement) => {
    customerElement.addEventListener("click", () => {
        const customerId = customerElement.dataset.customerId; // Ensure dataset is present in HTML
        navigateToChat(customerId);
    });
});

// Load messages when the page is loaded
window.onload = function () {
    loadMessages(); // Load messages
};

// Function to load chat messages
function loadMessages() {
    const urlParams = new URLSearchParams(window.location.search);
    const customerId = urlParams.get("customerId");

    if (!customerId) {
        console.error("No customerId in the URL");
        return;
    }

    const userNameElement = document.getElementById("userName");
    if (userNameElement) {
        userNameElement.innerText = customerId;
    }

    fetch("chat.json")
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            const customerChat = data.chats.find(
                (chat) => chat.customerId === customerId
            );

            if (customerChat) {
                const chatWindow = document.getElementById("chatWindow");
                chatWindow.innerHTML = ""; // Clear any previous messages

                customerChat.messages.forEach((chatItem) => {
                    const messageHTML = `
            <div class="message ${
                chatItem.sender === "self" ? "right" : "left"
            }">
              <img src="/images/Profilepic.png" alt="User Avatar" class="avatar">
              <div class="message-bubble">
                <p>${chatItem.message}</p>
                <div class="message-time">${chatItem.time}</div>
              </div>
            </div>
          `;
                    chatWindow.insertAdjacentHTML("beforeend", messageHTML);
                });

                chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll to the bottom
            } else {
                console.log("Chat data for this customer not found.");
            }
        })
        .catch((error) => console.error("Error loading chat:", error));
}

// Function to send a message
function sendMessage() {
    const messageInput = document.getElementById("messageInput");
    const message = messageInput.value.trim();
    const urlParams = new URLSearchParams(window.location.search);
    const customerId = urlParams.get("customerId");

    if (message && customerId) {
        const timestamp = new Date().toLocaleTimeString([], {
            hour: "2-digit",
            minute: "2-digit",
        });

        // Determine if the message is from the user
        const isSelf = true; // Change to true if sent by user
        const avatarPositionClass = isSelf ? "right" : "left"; // Class based on sender
        const avatarHtml = isSelf
            ? `<img src="images/Profilepic.png" alt="User Avatar" class="avatar">`
            : "";

        const messageHTML = `
      <div class="message ${avatarPositionClass}">
        ${avatarPositionClass === "left" ? avatarHtml : ""}
        <div class="message-bubble">
          <p>${message}</p>
          <div class="message-time">${timestamp}</div>
        </div>
        ${avatarPositionClass === "right" ? avatarHtml : ""}
      </div>
    `;

        const chatWindow = document.getElementById("chatWindow");
        chatWindow.insertAdjacentHTML("beforeend", messageHTML);
        messageInput.value = ""; // Reset message input
        chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll to the bottom
    }
}

// Function to navigate back to the chat list
function goBackChat() {
    window.location.href = "{{ route('umkm.message') }}";
}

// Add event listener to "Enter" key to send the message
document
    .getElementById("messageInput")
    .addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            sendMessage();
        }
    });

// Add event listener to back button
document.getElementById("backButton").addEventListener("click", goBackChat);
