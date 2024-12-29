<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Add this line
use Carbon\Carbon;

class RaphaelMessageController extends Controller
{
    // Show chat page with messages
    public function showChatPage(Request $request)
    {
        $customerId = $request->query('customerId'); // Get the customerId from the URL
        // Call the external API to fetch messages for the given customerId
        $messages = $this->getMessagesFromAPI($customerId);

        return view('Raphael_message_chatPage', compact('messages', 'customerId'));
    }

    // Get messages from external API
    private function getMessagesFromAPI($customerId)
    {
        $apiUrl = "https://umkmapi.azurewebsites.net/message/{$customerId}";

        // Use Laravel's HTTP Client to fetch messages
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $messages = $response->json(); // Get the response as an array

            // Sort the messages by 'sent_at' in ascending order (oldest first)
            usort($messages, function ($a, $b) {
                return strtotime($a['sent_at']) - strtotime($b['sent_at']);
            });

            return $messages;
        } else {
            // Handle error, log it, or return a default empty array
            Log::error('Failed to fetch messages from API', ['customerId' => $customerId]);
            return [];
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
            'sender_id' => 1,
            'sender_type' => "UMKM",
            'receiver_id' => 2,
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


        return view('Raphael_message_penjual');
    }

}