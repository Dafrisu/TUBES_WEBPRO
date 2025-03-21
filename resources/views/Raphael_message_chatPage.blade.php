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
    <!-- <script src="http://127.0.0.1:80/socket.io/socket.io.js"></script> -->
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
                        @php
                            $isSender = isset($message['receiver_type']) && $message['receiver_type'] == 'Pembeli';
                        @endphp
                        <div class="message {{ $isSender ? 'right' : 'left' }}">
                            @if(!$isSender)
                                <img src="{{ asset('images/Profilepic.png') }}" alt="User Avatar" class="avatar">
                            @endif
                            <div class="message-bubble">
                                <p>{{ $message['message'] ?? 'No message content' }}</p>
                                <div class="message-time">
                                    {{ isset($message['sent_at']) ? \Carbon\Carbon::parse($message['sent_at'])->format('H:i:s') : 'Unknown Time' }}
                                </div>
                            </div>
                            @if($isSender)
                                <img src="{{ asset('images/Profilepic.png') }}" alt="User Avatar" class="avatar">
                            @endif
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

    <!-- JavaScript -->
    <script>
        var socket = io("https://umkmkuapi.com", {
            transports: ["websocket"],
            withCredentials: true
        });

        socket.on("connect", () => {
            console.log("Connected to Socket.io server");
        });

        $(document).ready(function () {
            const userId = "{{ session('umkmID') }}";
            const receiverId = "{{ $id_pembeli }}";
            const apiUrl = `https://umkmkuapi.com/getLatestMsgUMKMPembeli/${userId}/${receiverId}`;
            const chatWindow = $("#chatWindow");
            let lastMessageId = 0;


            function scrollToBottom() {
                chatWindow.scrollTop(chatWindow[0].scrollHeight);
            }

            function getCurrentTime() {
                return new Date().toLocaleTimeString("en-GB", { hour: "2-digit", minute: "2-digit", second: "2-digit" });
            }





            socket.on("newMessage", function (message) {
                console.log("New message received:", message);

                const userId = "{{ session('umkmID') }}";
                const receiverId = "{{ $id_pembeli }}";

                // Ensure the message is for this conversation
                if ((message.id_umkm == userId && message.id_pembeli == receiverId) ||
                    (message.id_umkm == receiverId && message.id_pembeli == userId)) {

                    let messageClass = (message.id_pembeli == userId) ? "right" : "left";

                    // Prevent duplicate messages using message ID
                    if ($("#chatWindow").find(`[data-id='${message.id_chat}']`).length === 0) {
                        $("#chatWindow").append(`
                <div class="message ${messageClass}" data-id="${message.id_chat}">
                    ${messageClass === "left" ? `<img src="{{ asset('images/Profilepic.png') }}" alt="User Avatar" class="avatar">` : ""}
                    <div class="message-bubble">
                        <p>${message.message}</p>
                        <div class="message-time">${getCurrentTime()}</div>
                    </div>
                    ${messageClass === "right" ? `<img src="{{ asset('images/Profilepic.png') }}" alt="User Avatar" class="avatar">` : ""}
                </div>
            `);

                        scrollToBottom();
                    }
                }
            });


            $("#sendMessageForm").submit(function (e) {
                e.preventDefault();

                let messageText = $("#messageInput").val().trim();
                if (messageText) {
                    $.ajax({
                        url: $(this).attr("action"),
                        type: "POST",
                        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                        data: { message: messageText },
                        success: function (response) {
                            console.log("Message sent successfully", response);

                            fetchMessages();

                            $("#messageInput").val("");
                            scrollToBottom();
                        },
                        error: function (xhr) {
                            console.error("Error sending message:", xhr.responseText);
                        }
                    });
                }
            });

            $("#messageInput").keypress(function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $("#sendMessageForm").submit();
                }
            });

            scrollToBottom();

            // Fetch messages from API
            function fetchMessages() {
                $.ajax({
                    url: apiUrl,
                    type: "GET",
                    success: function (response) {
                        console.log("Fetched messages:", response);

                        let messages = Array.isArray(response) ? response : [response];

                        messages.forEach(message => {
                            if (message.id_chat > lastMessageId) {
                                let messageClass = message.receiver_type === "Pembeli" ? "right" : "left";

                                // Check if the message already exists before appending
                                if ($(`.message[data-id='${message.id_chat}']`).length === 0) {
                                    $("#chatWindow").append(`
                            <div class="message ${messageClass}" data-id="${message.id_chat}">
                                ${messageClass === "left" ? `<img src="{{ asset('images/Profilepic.png') }}" alt="User Avatar" class="avatar">` : ""}
                                <div class="message-bubble">
                                    <p>${message.message}</p>
                                    <div class="message-time">${message.sent_at ? message.sent_at.split('.')[0] : getCurrentTime()}</div>
                                </div>
                                ${messageClass === "right" ? `<img src="{{ asset('images/Profilepic.png') }}" alt="User Avatar" class="avatar">` : ""}
                            </div>
                        `);

                                    lastMessageId = message.id_chat; // Update the last message ID
                                    scrollToBottom();
                                }
                            }
                        });
                    },
                    error: function (xhr) {
                        console.error("Error fetching messages:", xhr.responseText);
                    }
                });
            }

            fetchMessages();
            // Run fetchMessages() only for real-time updates, NOT on page load
            setInterval(fetchMessages, 2000);

        });
    </script>




</body>

</html>