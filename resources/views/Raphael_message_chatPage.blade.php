<!-- Raphael_message_chatPage.blade.php -->
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
    <script src="{{ asset('json/chat.json') }}"></script>

</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <a href="{{ route('umkm.message') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="chat-user-info">
                <h1 id="userName">User Name</h1>
                <p id="userStatus">Online</p>
            </div>
        </div>
        <div class="chat-window" id="chatWindow">
            <!-- Chat messages dynamically inserted here -->
        </div>
        <div class="chat-input">
            <input type="text" placeholder="Type a message..." id="messageInput" />
            <button class="send-button" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
    <script src="{{ asset('js/Raphael_Chat.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", loadMessages);
    </script>
</body>
</html>
