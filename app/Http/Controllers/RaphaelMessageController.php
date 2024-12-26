<?php

namespace App\Http\Controllers;

use App\Models\RaphaelMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RaphaelMessageController extends Controller
{
    public function index()
    {
        return view('Raphael_message_penjual');
    }

    public function getMessages(Request $request)
    {
        $section = $request->input('section', 'open');
        $search = $request->input('search');
        $sort = $request->input('sort', 'newest');

        $query = RaphaelMessage::query();

        // Apply section filter
        switch ($section) {
            case 'open':
                $query->open();
                break;
            case 'unread':
                $query->unread();
                break;
            case 'unreplied':
                $query->unreplied();
                break;
        }

        // Apply search if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        if ($sort === 'newest') {
            $query->orderBy('time', 'desc');
        } else {
            $query->orderBy('time', 'asc');
        }

        $messages = $query->get();

        return Response::json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'name' => 'required|string',
        ]);

        $message = RaphaelMessage::create([
            'name' => $request->name,
            'message' => $request->message,
            'time' => now(),
            'status' => 'open',
            'is_seller_message' => true
        ]);

        return Response::json($message);
    }

    public function updateMessageStatus(Request $request, RaphaelMessage $message)
    {
        $request->validate([
            'status' => 'required|in:open,unread,unreplied'
        ]);

        $message->update([
            'status' => $request->status
        ]);

        return Response::json($message);
    }

    public function getChatHistory(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $messages = RaphaelMessage::where('name', $request->name)
            ->orderBy('time', 'asc')
            ->get();

        return Response::json($messages);
    }
}