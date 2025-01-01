<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RaphaelMessageController extends Controller
{
    // Show chat page with messages
    public function showChatPage(Request $request)
    {
        $customerId = $request->query('customerId');
        $messages = $this->getMessagesFromAPI($customerId);

        return view('Raphael_message_chatPage', compact('messages', 'customerId'));
    }

    // Get messages from external API
    private function getMessagesFromAPI($customerId)
    {
        $customerId = session('umkmID');
        $apiUrl = "localhost/message/msgUMKM/{$customerId}";

        // Use Laravel's HTTP Client to fetch messages
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $messages = $response->json();

            // Sort the messages by 'sent_at' in ascending order (oldest first)
            usort($messages, function ($a, $b) {
                return $a['id_chat'] - $b['id_chat'];
            });

            return $messages;
        } else {
            // Handle error, log it, or return a default empty array
            Log::error('Failed to fetch messages from API', ['customerId' => $customerId]);
            return [];
        }
    }

    public function getmessageumkm($id)
    {
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false])->get('localhost/message/msgUMKM/' . $id);

            if ($response->successful()) {
                $messages = $response->json();
                return view('Raphael_messageRead', compact('messages'));
            } else {
                throw new \Exception('message tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
        }
    }


    // Send message via API
    public function sendMessage(Request $request)
    {
        // Validate incoming request
        $currentTime = Carbon::now(timezone: 'Asia/Jakarta');
        $formattedTime = $currentTime->format('Y-m-d H:i:s');

        // Data from the request
        $message = $request->input('message');
        $senderId = $request->input('sender_id');
        $senderType = $request->input('sender_type');
        $receiverId = $request->input('receiver_id');
        $receiverType = $request->input('receiver_type');

        // API endpoint URL
        $apiUrl = 'https://umkmapi.azurewebsites.net/message';

        // Prepare the data to send to the API
        $data = [
            'message' => $message,
            'sender_id' => 2,
            'sender_type' => "UMKM",
            'receiver_id' => 1,
            'receiver_type' => "Pembeli",
            'sent_at' => $formattedTime,
        ];

        // Send the message using Laravel's HTTP Client
        $response = Http::withOptions(['verify' => false])->post($apiUrl, $data);

        // Check if the API request was successful
        if ($response->successful()) {
            Log::info('Message sent successfully', ['response' => $response->json()]);

            // Redirect to the chat page with a success message
            return redirect()->route('chatPage', ['customerId' => $receiverId])
                ->with('success', 'Message sent successfully!');
        } else {
            Log::error('Failed to send message', ['error' => $response->body()]);

            // Return an error message if the API fails
            return redirect()->back()->with('error', 'Failed to send message');
        }
    }



    public function showmsgPage(Request $request)
    {
        $customerId = session('umkmID');
        $messages = $this->getMessagesFromAPI($customerId); // Memanggil data pesan melalui API

        // Add default status if missing
        foreach ($messages as &$msg) {
            if (!isset($msg['status'])) {
                $msg['status'] = 'unknown'; // Default value
            }
        }

        // Filter messages
        $readMessages = array_filter($messages, fn($msg) => $msg['status'] === 'read');
        $unreadMessages = array_filter($messages, fn($msg) => $msg['status'] === 'unread');

        return view('Raphael_message_penjual', compact('readMessages', 'unreadMessages'));
    }

    public function showReadMessages(Request $request)
    {
        $customerId = session('umkmID');
        $messages = $this->getMessagesFromAPI($customerId); // Memanggil data pesan melalui API

        // Add default status if missing
        foreach ($messages as &$msg) {
            if (!isset($msg['status'])) {
                $msg['status'] = 'unknown'; // Default value
            }
        }

        // Filter read messages
        $readMessages = array_filter($messages, fn($msg) => $msg['status'] === 'read');

        return view('Raphael_messageRead', compact('readMessages'));
    }

    public function showUnreadMessages(Request $request)
    {
        $customerId = session('umkmID');
        $messages = $this->getMessagesFromAPI($customerId);

        // Add default status if missing
        foreach ($messages as &$msg) {
            if (!isset($msg['status'])) {
                $msg['status'] = 'unknown'; // Default value
            }
        }

        // Filter unread messages
        $unreadMessages = array_filter($messages, fn($msg) => $msg['status'] === 'unread');

        return view('Raphael_messageUnread', compact('unreadMessages'));
    }

}