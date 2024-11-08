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

let currentMessages = [];

function showChatSection(section) {
    const filtersBar = document.getElementById('filtersBar');
    const chatInterface = document.getElementById('chatInterface');
    const exampleMessages = document.getElementById('exampleMessages');
    const emptyMessage = document.getElementById('emptyMessage');

    filtersBar.style.display = 'block';
    chatInterface.style.display = 'none';
    exampleMessages.style.display = 'block';

    // Fetch the messages from the JSON file
    fetch('javascript/messages.json')  // Adjust the path if necessary
        .then(response => response.json())  // Parse the JSON response
        .then(data => {
            currentMessages = [...data[section]];  // Access the specific section (open, unread, unreplied)
            displayMessages(currentMessages);  // Display the messages
        })
        .catch(error => {
            console.error('Error loading messages:', error);  // Error handling
        });
}

function searchMessages(event) {
    if (event.key === 'Enter') {
        event.target.blur();  // Blur the input field when Enter is pressed
        return;
    }
    const query = event.target.value.toLowerCase();  // Get the search query in lowercase
    const filteredMessages = currentMessages.filter(msg => 
        msg.name.toLowerCase().includes(query) ||  // Filter by name
        msg.message.toLowerCase().includes(query)   // Filter by message
    );
    displayMessages(filteredMessages);  // Display the filtered messages
}

function sortMessages(event) {
    const sortBy = event.target.value;  // Get the selected sort option
    if (!sortBy) return;

    // Sort the messages based on time
    const sortedMessages = [...currentMessages].sort((a, b) => {
        const dateA = timeToDate(a.time);
        const dateB = timeToDate(b.time);
        return sortBy === 'newest' ? dateB - dateA : dateA - dateB;
    });
    
    displayMessages(sortedMessages);  // Display the sorted messages
}

function displayMessages(messageList) {
    const exampleMessages = document.getElementById('exampleMessages');
    const emptyMessage = document.getElementById('emptyMessage');
    
    exampleMessages.innerHTML = "";

    if (messageList.length === 0) {
        emptyMessage.style.display = 'block';  // Show "No messages" if the list is empty
    } else {
        emptyMessage.style.display = 'none';  // Hide "No messages" if there are messages
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

// Hamburger menu toggle functionality
const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");  // Toggle sidebar expansion
});