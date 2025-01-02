<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RaphaelMessageController extends Controller
{
    // Show chat page with messages
    public function showChatPage(Request $request, $id_pembeli)
    {
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false])->get('http://localhost/message/msgUMKM/' . $id, $id_pembeli);


            if ($response->successful()) {
                $messages = json_decode($response->body(), true);
                $customerName = isset($messages[0]['nama_lengkap']) ? $messages[0]['nama_lengkap'] : 'Customer Name';


                // $readMessages = array_filter($messages, fn($msg) => $msg['is_read']);
                return view('Raphael_message_chatPage', compact('messages', 'customerName'));
            } else {
                throw new \Exception('Message UMKM tidak ditemukan');
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
        $id = session('umkmID');
        $message = $request->input('message');
        $id_pembeli = $request->input('id_pembeli');
        $receiverType = $request->input('receiver_type');

        // API endpoint URL
        $apiUrl = 'localhost/message/msgUMKM/' . $id;


        // Prepare the data to send to the API
        $data = [
            'message' => $message,
            'id_umkm' => $id,
            'id_pembeli' => $id_pembeli,
            'receiver_type' => $receiverType,
            'sent_at' => $formattedTime,
        ];

        // Send the message using Laravel's HTTP Client
        $response = Http::withOptions(['verify' => false])->post($apiUrl, $data);

        // Check if the API request was successful
        if ($response->successful()) {
            Log::info('Message sent successfully', ['response' => $response->json()]);

            // Redirect to the chat page with a success message
            return redirect()->route('chatPage')
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

    // public function showinbox()
    // {
    //     $id = session('umkmID');

    //     try {
    //         if (!$id) {
    //             throw new \Exception('ID profile tidak ditemukan');
    //         }
    //         $respose = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/message/msgUMKM/' . $id);
    //         $profile = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getprofileumkm/' . $id)->json();
    //         if ($respose->successful()) {
    //             $message = $respose->json();
    //             return view('Raphael_message_penjual', compact('message', 'profile'));
    //         } else {
    //             throw new \Exception('Message UMKM tidak ditemukan');
    //         }
    //     } catch (\Exception $e) {
    //         return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
    //     }
    // }

    public function showinbox()
    {
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getprofileumkm/' . $id);

            if ($respose->successful()) {
                $profile = $respose->json();
                return view('Raphael_message_penjual', compact('profile'));
            } else {
                throw new \Exception('Profile tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
        }
    }

    public function showReadMessages($id_pembeli)
    {
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false])->get('http://localhost/message/msgUMKM/' . $id, $id_pembeli);

            if ($response->successful()) {
                $messages = json_decode($response->body(), true);
                $readMessages = array_filter($messages, fn($msg) => $msg['is_read']);
                return view('Raphael_messageRead', compact('readMessages'));
            } else {
                throw new \Exception('Message UMKM tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
        }
    }


    public function showUnreadMessages()
    {
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false])->get('http://localhost/message/msgUMKM/' . $id);

            if ($response->successful()) {
                $messages = json_decode($response->body(), true);
                $unreadMessages = array_filter($messages, fn($msg) => !$msg['is_read']);
                return view('Raphael_messageUnread', compact('unreadMessages'));
            } else {
                throw new \Exception('Message UMKM tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
        }
    }
}