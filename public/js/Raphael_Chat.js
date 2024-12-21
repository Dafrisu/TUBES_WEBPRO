function navigateToChat(customerId) {
  window.location.href = `Raphael_message_chatPage.html?customerId=${customerId}`;
}

document.querySelectorAll(".customer").forEach((customerElement) => {
  customerElement.addEventListener("click", () => {
    const customerId = customerElement.dataset.customerId; // Ensure you have this dataset in HTML
    navigateToChat(customerId);
  });
});

window.onload = function () {
  loadMessages(); // Load the messages when the page loads
};

function loadMessages() {
  const urlParams = new URLSearchParams(window.location.search);
  const customerId = urlParams.get("customerId");

  if (!customerId) {
    console.error("No customerId in the URL");
    return;
  }

  console.log("Customer ID:", customerId); // Debugging output to check customerId

  // Set the customer name in the header
  const userNameElement = document.getElementById("userName");
  if (userNameElement) {
    userNameElement.innerText = customerId; // Update the header with customer name
    console.log("Updated userName to:", customerId); // Debugging output
  } else {
    console.error("User name element not found.");
  }

  fetch("javascript/chat.json")
    .then((response) => response.json())
    .then((data) => {
      const customerChat = data.chats.find(
        (chat) => chat.customerId === customerId
      );

      if (customerChat) {
        const chatWindow = document.getElementById("chatWindow");
        // Clear previous messages

        customerChat.messages.forEach((chatItem) => {
          const messageHTML = `
            <div class="message ${
              chatItem.sender === "self" ? "right" : "left"
            }">
              <img src="assets/Profilepic.png" alt="User Avatar" class="avatar">
              <div class="message-bubble">
                <p>${chatItem.message}</p>
                <div class="message-time">${chatItem.time}</div>
              </div>
            </div>
          `;
          chatWindow.insertAdjacentHTML("beforeend", messageHTML);
        });

        chatWindow.scrollTop = chatWindow.scrollHeight;
      } else {
        console.log("Chat data for this customer not found.");
      }
    })
    .catch((error) => console.error("Error loading chat:", error));
}

// Send message
function sendMessage() {
  const messageInput = document.getElementById("messageInput");
  const message = messageInput.value.trim();
  const urlParams = new URLSearchParams(window.location.search);
  const customerId = urlParams.get("customerId"); // fetch customerId

  if (message && customerId) {
    const timestamp = new Date().toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
    });

    // cek user
    const isSelf = true; // jika true berarti di kirim oleh user
    const avatarPositionClass = isSelf ? "right" : "left"; // assign class berdasarkan user
    const avatarHtml = isSelf
      ? `<img src="assets/Profilepic.png" alt="User Avatar" class="avatar">`
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
    messageInput.value = ""; //reset chat
    chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll
  }
}

//navigasi back
function goBackChat() {
  window.location.href = "Raphael_message_penjual.html";
}

// inisiasi chat pada page
window.onload = function () {
  loadMessages();
};

// mengirim msg pencet enter
document
  .getElementById("messageInput")
  .addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      sendMessage();
    }
  });

// Back button
document.getElementById("backButton").addEventListener("click", goBackChat);



