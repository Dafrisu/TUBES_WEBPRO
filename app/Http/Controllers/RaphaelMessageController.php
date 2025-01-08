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
            $response = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/message/msgUMKM/' . $id);
            $getmessages = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getmessagebyumkmandpembeli/' . $id . '/' . $id_pembeli);

            if ($response->successful() && $getmessages->successful()) {
                $messages = json_decode($response->body(), true);
                $customerName = isset($messages[0]['nama_lengkap']) ? $messages[0]['nama_lengkap'] : 'Customer Name';
                $messageumkmandpembeli = $getmessages->json();

                return view('Raphael_message_chatPage', compact('messages', 'customerName', 'messageumkmandpembeli'));
            } else {
                throw new \Exception('Message UMKM tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
        }
    }



    // Send message via API
    public function sendMessage(Request $request, $id_pembeli)
    {


        // Validate incoming request
        $currentTime = Carbon::now(timezone: 'Asia/Jakarta');
        $formattedTime = $currentTime->format('Y-m-d H:i:s');

        // Data from the request
        $id = session('umkmID');
        $message = $request->input('message');

        // API endpoint URL
        $apiUrl = 'https://umkmapi.azurewebsites.net/sendchat/' . $id . '/' . $id_pembeli;


        $data = [
            'message' => $message,
            'sent_at' => $formattedTime,
            "is_read" => false,
            "id_kurir" => null
        ];

        // Send the message using Laravel's HTTP Client
        $response = Http::withOptions(['verify' => false])->post($apiUrl, $data);

        if ($response->successful()) {
            Log::info('Message sent successfully', ['response' => $response->json()]);

            return redirect()->route('messagepage', $id_pembeli)
                ->with('success', 'Message sent successfully!');
        } else {
            Log::error('Failed to send message', ['error' => $response->body()]);

            return redirect()->back()->with('error', 'Failed to send message');
        }
    }



    public function showmsgPage(Request $request)
    {
        return view('Raphael_message_penjual');
    }

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

    public function showReadMessages()
    {
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/message/msgUMKM/' . $id);

            if ($response->successful()) {
                $messages = json_decode($response->body(), true);
                $readMessages = array_filter($messages, fn($msg) => $msg['is_read']);
                // Debugging line to check the messages
                foreach ($readMessages as $msg) {
                    Log::info('Message ID Pembeli: ' . $msg['id_pembeli']);
                }
                return view('Raphael_messageRead', compact('readMessages'));
            } else {
                throw new \Exception('Message UMKM tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard', ['id' => $id])->with('error', $e->getMessage());
        }
    }


    public function showUnreadMessages()
    {
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/message/msgUMKM/' . $id);

            if ($response->successful()) {
                $messages = json_decode($response->body(), true);
                $unreadMessages = array_filter($messages, fn($msg) => !$msg['is_read']);
                return view('Raphael_messageUnread', compact('unreadMessages'));
            } else {
                throw new \Exception('Message UMKM tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard', ['id' => $id])->with('error', $e->getMessage());
        }
    }
}