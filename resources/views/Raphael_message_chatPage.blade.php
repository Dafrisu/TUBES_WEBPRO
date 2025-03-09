<!-- Raphael_message_chatPage.blade -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/Raphael_Chat.css') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <div class="chat-container">
        <!-- Chat Header -->
        <div class="chat-header">
            <a href="/message" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="chat-user-info">
                <h1 id="userName">{{ $customerName }}</h1>
            </div>
        </div>

        <!-- Chat Messages Window -->
        <div class="chat-window" id="chatWindow">
            @foreach($messageumkmandpembeli as $message)
                <div class="message {{ $message['receiver_type'] == 'Pembeli' ? 'right' : 'left' }}">
                    <img src="{{ asset('images/Profilepic.png') }}" alt="User Avatar" class="avatar">
                    <div class="message-bubble">
                        <p>{{ $message['message'] }}</p>
                        <div class="message-time">{{ \Carbon\Carbon::parse($message['sent_at'])->format('H:i:s') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Message Input Form -->
        @if(!empty($messages))
            <form id="sendMessageForm" action="{{ route('sendMessage', $id_pembeli) }}" method="POST">
                @csrf
                <div class="chat-input">
                    <input type="text" name="message" id="messageInput" placeholder="Type a message..." required />
                    <button type="submit" class="send-button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        @endif
    </div>

    <!-- JavaScript for Real-Time Chat -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chatWindow = document.getElementById("chatWindow");
            const messageInput = document.getElementById("messageInput");
            const sendMessageForm = document.getElementById("sendMessageForm");

            sendMessageForm.addEventListener("submit", function (e) {
                e.preventDefault(); // Prevent page refresh

                const message = messageInput.value.trim();
                if (message === "") return;

                // Append message to chat UI before sending
                appendMessage(message, "right");
                messageInput.value = "";
                messageInput.dispatchEvent(new Event("input"));
                sendMessageForm.reset();
                messageInput.focus();

                // Send message using Fetch API
                fetch(sendMessageForm.action, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: JSON.stringify({ message: message }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error("Message not sent:", data);
                        } 
                    })
                    .catch(error => console.error("Error:", error));
            });

            function appendMessage(message, position) {
                const messageDiv = document.createElement("div");
                messageDiv.classList.add("message", position);
                messageDiv.innerHTML = `
                    <img src="{{ asset('images/Profilepic.png') }}" alt="User Avatar" class="avatar">
                    <div class="message-bubble">
                        <p>${message}</p>
                        <div class="message-time">${new Date().toLocaleTimeString()}</div>
                    </div>
                `;
                chatWindow.appendChild(messageDiv);
                chatWindow.scrollTop = chatWindow.scrollHeight; // Auto-scroll to latest message
            }
        });
    </script>

</body>

</html>