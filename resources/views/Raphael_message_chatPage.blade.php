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
                <h1 id="userName">{{ $customerName }}</h1>
            </div>
        </div>

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

        <!-- Message Form -->
        @if(!empty($messages))
            @php $lastMessage = end($messages); @endphp
            <form action="{{ route('sendMessage', $lastMessage['id_pembeli']) }}" method="POST">
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
</body>

</html>