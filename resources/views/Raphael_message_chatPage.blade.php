<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="css/Raphael_Chat.css" />
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <button class="back-button" onclick="goBackChat()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="chat-user-info">
                <h1 id="userName">User Name</h1>
                <p id="userStatus">Online</p>
            </div>
        </div>
        
        <div class="chat-window" id="chatWindow">
            <!-- Chat messages will be dynamically inserted here -->
        </div>
        
        <div class="chat-input">
            <input type="text" placeholder="Type a message..." id="messageInput" />
            <button class="send-button" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
    <script src="javascript/Raphael_Chat.js"></script>
    
</body>
</html>
