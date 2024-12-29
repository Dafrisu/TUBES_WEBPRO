<!-- Raphael_message_chatPage.blade -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/Raphael_Chat.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="chat-container">
        <div class="chat-header">
            <a href="/message" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="chat-user-info">
                <h1 id="userName">Customer ID: {{ $customerId }}</h1>
                <p id="userStatus">Online</p>
            </div>
        </div>

        <div class="chat-window" id="chatWindow">
            @foreach($messages as $message)
                <div class="message {{ $message['sender_type'] == 'UMKM' ? 'right' : 'left' }}">
                    <img src="{{ asset('images/Profilepic.png') }}" alt="User Avatar" class="avatar">
                    <div class="message-bubble">
                        <p>{{ $message['message'] }}</p>
                        <div class="message-time">{{ \Carbon\Carbon::parse($message['sent_at'])->format('H:i:s') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="chat-input">
            <input type="text" id="messageInput" placeholder="Type a message..." required />
            <input type="hidden" id="customerId" value="{{ $customerId }}">
            <button type="button" id="sendButton" class="send-button" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

    </div>
</body>

</html>