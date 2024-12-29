<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Add this line

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
            return $response->json(); // Return the response as an array
        } else {
            // Handle error, log it, or return a default empty array
            Log::error('Failed to fetch messages from API', ['customerId' => $customerId]);
            return [];
        }
    }

    // Send message via API
    public function sendMessage(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'message' => 'required|string|max:255',
            'sender_id' => 'required|string',
            'sender_type' => 'required|string',
            'receiver_id' => 'required|string',
            'receiver_type' => 'required|string',
        ]);

        // Retrieve the data from the form
        $message = $request->input('message');
        $senderId = $request->input('sender_id');
        $senderType = $request->input('sender_type');
        $receiverId = $request->input('receiver_id');
        $receiverType = $request->input('receiver_type');

        $apiUrl = 'https://umkmapi.azurewebsites.net/message';

        // Prepare the data to be sent to the API
        $data = [
            'message' => $message,
            'sender_id' => $senderId,
            'sender_type' => $senderType,
            'receiver_id' => $receiverId,
            'receiver_type' => $receiverType,
        ];

        // Send the message to the API using Laravel's HTTP Client
        $response = Http::post($apiUrl, $data);

        // Check for a successful response from the API
        if ($response->successful()) {
            // Return to the previous page with a success message
            return back()->with('message', 'Message sent successfully!');
        } else {
            // Log the error if the API call fails
            Log::error('Failed to send message', ['data' => $data, 'error' => $response->body()]);

            // Return to the previous page with an error message
            return back()->withErrors(['error' => 'Failed to send message. Please try again later.']);
        }
    }
}