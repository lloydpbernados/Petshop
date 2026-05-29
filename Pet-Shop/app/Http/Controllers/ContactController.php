<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if (Auth::check()) {
            // ── Logged-in customer ──────────────────────────────────
            $user  = Auth::user();
            $convo = Conversation::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name'     => $user->name,
                    'email'    => $user->email,
                    'initials' => $this->initials($user->name),
                    'status'   => 'Online',
                    'category' => 'Customer Inquiry',
                ]
            );

            $convo->messages()->create([
                'type' => 'received',
                'text' => $data['message'],
            ]);

        } else {
            // ── Guest ───────────────────────────────────────────────
            // 1. Save to admin Messages panel (user_id = null)
            $convo = Conversation::create([
                'user_id'  => null,
                'name'     => $data['name'],
                'email'    => $data['email'],
                'initials' => $this->initials($data['name']),
                'status'   => 'Away',
                'category' => 'Guest Inquiry',
            ]);

            $convo->messages()->create([
                'type' => 'received',
                'text' => $data['message'],
            ]);

            // 2. Send email notification to admin
            try {
                Mail::raw(
                    "New guest message from PawHaven website\n\n" .
                    "Name:    {$data['name']}\n" .
                    "Email:   {$data['email']}\n\n" .
                    "Message:\n{$data['message']}",
                    function ($mail) use ($data) {
                        $mail->to(config('mail.admin_address', 'admin@pawhaven.ph'))
                             ->subject("PawHaven Guest Message: {$data['name']}");
                    }
                );
            } catch (\Exception $e) {
                Log::warning('Guest contact email failed: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true]);
    }

    // ── Customer: get their own conversation + messages ──────────────
    public function myMessages()
    {
        $user  = Auth::user();
        $convo = Conversation::where('user_id', $user->id)
                             ->with('messages')
                             ->first();

        if (!$convo) {
            return response()->json(['conversation' => null, 'messages' => []]);
        }

        return response()->json([
            'conversation' => [
                'id'       => $convo->id,
                'name'     => $convo->name,
                'initials' => $convo->initials,
                'status'   => $convo->status,
            ],
            'messages' => $convo->messages->map(fn($m) => [
                'id'   => $m->id,
                'type' => $m->type,
                'text' => $m->text,
                'time' => $m->formatted_time,
            ]),
        ]);
    }

    // ── Customer: send a new message ─────────────────────────────────
    public function myMessageSend(Request $request)
    {
        $data = $request->validate(['text' => 'required|string|max:2000']);
        $user = Auth::user();

        $convo = Conversation::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name'     => $user->name,
                'email'    => $user->email,
                'initials' => $this->initials($user->name),
                'status'   => 'Online',
                'category' => 'Customer Inquiry',
            ]
        );

        $message = $convo->messages()->create([
            'type' => 'received',
            'text' => $data['text'],
        ]);

        return response()->json([
            'id'   => $message->id,
            'type' => $message->type,
            'text' => $message->text,
            'time' => $message->formatted_time,
        ], 201);
    }

    private function initials(string $name): string
    {
        $parts = explode(' ', trim($name));
        return strtoupper(
            substr($parts[0], 0, 1) .
            (isset($parts[1]) ? substr($parts[1], 0, 1) : '')
        );
    }
}