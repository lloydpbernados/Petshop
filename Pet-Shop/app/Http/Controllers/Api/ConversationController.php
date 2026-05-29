<?php
// app/Http/Controllers/Api/ConversationController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ConversationController extends Controller
{
    /** List all conversations with latest message preview */
    public function index()
    {
        $convos = Conversation::with(['latestMessage'])
            ->latest()
            ->get()
            ->map(fn($c) => [
                'id'          => $c->id,
                'name'        => $c->name,
                'initials'    => $c->initials,
                'status'      => $c->status,
                'category'    => $c->category,
                'email'       => $c->email,
                'lastMessage' => $c->latestMessage?->text ?? '',
                'lastTime'    => $c->latestMessage?->formatted_time ?? '',
            ]);

        return response()->json($convos);
    }

    /** Get all messages for a conversation */
    public function messages(Conversation $conversation)
    {
        return response()->json([
            'conversation' => [
                'id'       => $conversation->id,
                'name'     => $conversation->name,
                'initials' => $conversation->initials,
                'status'   => $conversation->status,
                'category' => $conversation->category,
                'email'    => $conversation->email,
                'user_id'  => $conversation->user_id,
            ],
            'messages' => $conversation->messages->map(fn($m) => [
                'id'   => $m->id,
                'type' => $m->type,
                'text' => $m->text,
                'time' => $m->formatted_time,
            ]),
        ]);
    }

    /** Send a reply from the admin */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $data = $request->validate(['text' => 'required|string|max:2000']);

        // Save reply to DB
        $message = $conversation->messages()->create([
            'type' => 'sent',
            'text' => $data['text'],
        ]);

        // ── If guest (no user_id) → email the reply with reply link ──
        if (is_null($conversation->user_id) && $conversation->email) {
            try {
                // ✅ Generate unique reply link using the token
                $replyLink = url('/guest-reply/' . $conversation->reply_token);

                Mail::raw(
                    "Hi {$conversation->name},\n\n" .
                    "You have a new reply from PawHaven:\n\n" .
                    "\"{$data['text']}\"\n\n" .
                    "---\n" .
                    "To reply, click this link:\n" .
                    "{$replyLink}\n\n" .
                    "PawHaven Team 🐾",
                    function ($mail) use ($conversation) {
                        $mail->to($conversation->email, $conversation->name)
                             ->subject('PawHaven replied to your message 🐾')
                             ->from(
                                 config('mail.from.address'),
                                 'PawHaven Support'
                             );
                        // ✅ No replyTo — guest must use the link, not email reply
                    }
                );
            } catch (\Exception $e) {
                Log::warning('Failed to email guest reply: ' . $e->getMessage());
            }
        }

        // ── Logged-in customers see replies in their Messages drawer ─
        // No email needed — they poll /api/my-messages from the shop page

        return response()->json([
            'id'   => $message->id,
            'type' => $message->type,
            'text' => $message->text,
            'time' => $message->formatted_time,
        ], 201);
    }

    /** Delete an entire conversation */
    public function destroy(Conversation $conversation)
    {
        $conversation->delete();
        return response()->json(['deleted' => true]);
    }
}