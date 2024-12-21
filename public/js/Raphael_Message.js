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

function showChatSection(section) {
  const filtersBar = document.getElementById("filtersBar");
  const chatInterface = document.getElementById("chatInterface");
  const exampleMessages = document.getElementById("exampleMessages");
  const emptyMessage = document.getElementById("emptyMessage");

  filtersBar.style.display = "block";
  chatInterface.style.display = "none";
  exampleMessages.style.display = "block";

  // Fetch the messages from the JSON file
  fetch("javascript/messages.json") // Adjust the path if necessary
    .then((response) => response.json()) // Parse the JSON response
    .then((data) => {
      currentMessages = [...data[section]]; // Access the specific section (open, unread, unreplied)
      displayMessages(currentMessages); // Display the messages
    })
    .catch((error) => {
      console.error("Error loading messages:", error);
      alert("Gagal memuat pesan, periksa kembali tautan file JSON.");
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
  fetch("javascript/messages.json")
    .then((response) => response.json())
    .then((data) => {
      // Flatten all messages into a single list
      const allMessages = [...data.open, ...data.unread, ...data.unreplied];
      // Filter messages that belong to the specific user
      currentMessages = allMessages.filter((msg) => msg.name === userName);

      if (currentMessages.length > 0) {
        displayChatMessages(currentMessages);
      } else {
        document.getElementById("chatWindow").innerHTML =
          "<p>No messages found for this user.</p>";
      }
    })
    .catch((error) => {
      console.error("Error loading messages:", error);
    });
}

function displayChat(messages) {
  const chatWindow = document.getElementById("chatWindow");
  chatWindow.innerHTML = ""; // Clear existing messages

  messages.forEach((msg) => {
    const messageHTML = `
        <div class="message left">
            <img src="assets/Profilepic.png" alt="User Avatar" class="avatar">
            <div class="message-bubble">
                <p>${msg.message}</p>
                <div class="message-time">${msg.time}</div>
            </div>
        </div>
      `;
    chatWindow.insertAdjacentHTML("beforeend", messageHTML);
  });
}
loadChatMessages(chatUserName);

// Hamburger menu toggle functionality
const hamBurger = document.querySelector(".toggle-btn");

if (hamBurger) {
  hamBurger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
  });
}

function goBackDashboard() {
  window.location.href = "Dafa_Dashboard.html";
}

const urlParams = new URLSearchParams(window.location.search);
const chatUserName = urlParams.get("name") || "Unknown User";
const chatUserMessage = urlParams.get("message") || "Online";
document.getElementById("chatUserName").textContent = chatUserName;
document.getElementById("chatUserMessage").textContent = chatUserMessage;



// Initialize chat functionality
const messageInput = document.getElementById("messageInput");
const chatWindow = document.getElementById("chatWindow");

function sendMessage() {
  const message = messageInput.value.trim();
  if (message) {
    const timestamp = new Date().toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
    });
    const messageHTML = `
                    <div class="message right">
                        <div class="message-bubble">
                            <p>${message}</p>
                            <div class="message-time">${timestamp}</div>
                        </div>
                        <img src="profile2.jpg" alt="User Avatar" class="avatar">
                    </div>
                `;
    chatWindow.insertAdjacentHTML("beforeend", messageHTML);
    messageInput.value = "";
    chatWindow.scrollTop = chatWindow.scrollHeight;
  }
}

// Send message on Enter key press
messageInput.addEventListener("keypress", function (e) {
  if (e.key === "Enter") {
    sendMessage();
  }
});

// Scroll to bottom on page load
window.onload = function () {
  chatWindow.scrollTop = chatWindow.scrollHeight;
};

document.getElementById("backButton").addEventListener("click", goBack);

function goBackChat() {
    window.history.back();
}

function navigateToChat(name, message) {
  const encodedName = encodeURIComponent(name);
  const encodedMessage = encodeURIComponent(message);
  window.location.href = `Raphael_message_chatPage.html?name=${encodedName}&message=${encodedMessage}`;
}



