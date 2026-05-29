<?php
// app/Http/Controllers/GuestReplyController.php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class GuestReplyController extends Controller
{
    public function show(string $token)
    {
        $conversation = Conversation::where('reply_token', $token)
                                    ->with('messages')
                                    ->firstOrFail();

        return view('guest-reply', compact('conversation', 'token'));
    }

    public function send(Request $request, string $token)
    {
        $conversation = Conversation::where('reply_token', $token)->firstOrFail();

        $data = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $conversation->messages()->create([
            'type' => 'received',
            'text' => $data['message'],
        ]);

        return back()->with('success', 'Your reply has been sent! 🐾');
    }
}