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

            $response = Http::withOptions(['verify' => false])
                ->get('https://umkmapi-production.up.railway.app/message/msgUMKM/' . $id);
            $getmessages = Http::withOptions(['verify' => false])
                ->get('https://umkmapi-production.up.railway.app/getmsgUMKMPembeli/' . $id . '/' . $id_pembeli);

            if ($response->successful() && $getmessages->successful()) {
                $messages = json_decode($response->body(), true);
                $messageumkmandpembeli = $getmessages->json();

                if (empty($messages)) {
                    throw new \Exception('Message UMKM tidak ditemukan');
                }


                // Cari customerName berdasarkan id_pembeli
                $customerName = 'Customer Name';
                foreach ($messages as $message) {
                    if ($message['id_pembeli'] == $id_pembeli) {
                        $customerName = $message['nama_lengkap'];
                        break;
                    }
                }

                return view('Raphael_message_chatPage', compact('messages', 'customerName', 'messageumkmandpembeli', 'id_pembeli'));
            } else {
                throw new \Exception('Message UMKM tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
        }
    }




    // Send message via API
    private $nodeApiUrl = "https://umkmapi-production.up.railway.app"; // Railway Backend

    public function sendMessage(Request $request, $id_pembeli)
    {


        // Validate incoming request
        $currentTime = Carbon::now(timezone: 'Asia/Jakarta');
        $formattedTime = $currentTime->format('Y-m-d H:i:s');

        // Data from the request
        $id = session('umkmID');
        $message = $request->input('message');

        // API endpoint URL
        $apiUrl = 'https://umkmapi-production.up.railway.app/sendchat/umkmkepembeli/' . $id . '/' . $id_pembeli;


        $data = [
            'message' => $message,
            'sent_at' => $formattedTime,
            "is_read" => false,
            "id_kurir" => null,
            "receiver_type" => "Pembeli",
        ];

        // Send the message using Laravel's HTTP Client
        $response = Http::withOptions(['verify' => false])->post($apiUrl, $data);

        if ($response->successful()) {
            Log::info('Message sent successfully', ['response' => $response->json()]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!',
                'data' => $response->json()
            ]);
        } else {
            Log::error('Failed to send message', ['error' => $response->body()]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to send message',
            ], 500);
        }

    }



    public function showmsgPage(Request $request)
    {
        return view('Raphael_message_penjual');
    }

    public function showinbox()
    {
        $this->getprofileumkm();
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id);

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

    public function showReadMessages(Request $request)
    {
        $this->getprofileumkm();
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/message/msgUMKM/' . $id);

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
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
        }
    }


    public function showUnreadMessages(Request $request)
    {
        $this->getprofileumkm();
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/message/msgUMKM/' . $id);

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

    public function markMessageAsRead(Request $request)
    {
        try {
            $selectedMessages = $request->input('selected_messages', []);

            if (empty($selectedMessages)) {
                return redirect()->route('umkm.messages.unread')->with('error', 'No messages selected');
            }

            foreach ($selectedMessages as $id_pembeli) {
                $response = Http::withOptions(['verify' => false])
                    ->put("https://umkmapi-production.up.railway.app/message/read/$id_pembeli");

                if (!$response->successful()) {
                    throw new \Exception("Failed to mark message for ID $id_pembeli as read");
                }
            }

            return redirect()->route('umkm.messages.unread')->with('success', 'Selected messages marked as read');
        } catch (\Exception $e) {
            return redirect()->route('umkm.messages.unread')->with('error', $e->getMessage());
        }
    }

    public function getMessagesFromNode($umkmId, $pembeliId)
    {
        $url = "https://umkmapi-production.up.railway.app/getmsgUMKMPembeli/$umkmId/$pembeliId";

        try {
            $response = Http::get($url);
            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Failed to fetch messages'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getprofileumkm()
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }

            // Check if profile is already stored in session
            if (session()->has('umkmProfile')) {
                return session('umkmProfile');
            }

            $response = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id);

            if ($response->successful()) {
                $profile = $response->json();
                session(['umkmProfile' => $profile]); // Store profile in session
                return $profile;
            } else {
                throw new \Exception('Profile tidak ditemukan');
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function read()
    {
        $this->getprofileumkm(); // Fetch profile and store it in session
        return view('Raphael_messageRead');
    }

}
