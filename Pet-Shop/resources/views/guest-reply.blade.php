<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to PawHaven</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #FDF8F1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .card {
            background: #fff;
            border-radius: 1.5rem;
            border: 1.5px solid #F3E9DC;
            padding: 2.5rem;
            max-width: 560px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(45,36,30,0.10);
        }
        .logo { font-size: 1.4rem; font-weight: 800; color: #2D241E; margin-bottom: 1.5rem; }
        .logo span { color: #E68A39; }
        h2 { font-size: 1.3rem; font-weight: 700; color: #2D241E; margin-bottom: 0.4rem; }
        p.sub { color: #A68B6D; font-size: 0.9rem; margin-bottom: 1.75rem; }
        .thread {
            background: #FDF8F1; border-radius: 1rem;
            padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            max-height: 260px; overflow-y: auto;
            display: flex; flex-direction: column; gap: 0.85rem;
        }
        .bubble-row { display: flex; flex-direction: column; }
        .bubble-row.out { align-items: flex-end; }
        .bubble-row.in  { align-items: flex-start; }
        .bubble {
            padding: 9px 14px; border-radius: 16px;
            font-size: 0.88rem; line-height: 1.5; max-width: 85%;
        }
        .bubble.out { background: #E68A39; color: #fff; border-radius: 16px 16px 4px 16px; }
        .bubble.in  { background: #fff; color: #2D241E; border: 1px solid #F3E9DC; border-radius: 16px 16px 16px 4px; }
        .bubble-time { font-size: 0.68rem; color: #A68B6D; margin-top: 3px; }
        .who { font-size: 0.7rem; font-weight: 700; color: #A68B6D; text-transform: uppercase; margin-bottom: 3px; }
        textarea {
            width: 100%; padding: 12px 16px;
            border: 1.5px solid #F3E9DC; border-radius: 1rem;
            font-size: 0.95rem; font-family: inherit;
            color: #2D241E; background: #FDF8F1;
            resize: vertical; min-height: 110px; outline: none;
            transition: border-color 0.2s; margin-bottom: 1rem;
        }
        textarea:focus { border-color: #E68A39; box-shadow: 0 0 0 3px rgba(230,138,57,0.15); }
        button {
            width: 100%; background: #E68A39; color: #fff;
            border: none; padding: 13px; border-radius: 2rem;
            font-size: 0.95rem; font-weight: 700; cursor: pointer;
        }
        button:hover { background: #cf7529; }
        .alert-success {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #166534; padding: 12px 16px;
            border-radius: 0.75rem; font-size: 0.88rem; margin-bottom: 1.25rem;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">🐾 Paw<span>Haven</span></div>
    <h2>Continue Your Conversation</h2>
    <p class="sub">Hi {{ $conversation->name }}, reply to PawHaven below.</p>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Message thread --}}
    <div class="thread" id="thread">
        @foreach($conversation->messages as $msg)
            <div class="bubble-row {{ $msg->type === 'sent' ? 'out' : 'in' }}">
                <div class="who">{{ $msg->type === 'sent' ? 'PawHaven' : $conversation->name }}</div>
                <div class="bubble {{ $msg->type === 'sent' ? 'out' : 'in' }}">{{ $msg->text }}</div>
                <span class="bubble-time">{{ $msg->formatted_time }}</span>
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('guest.reply.send', $token) }}">
        @csrf
        <textarea name="message" placeholder="Write your reply here…" required>{{ old('message') }}</textarea>
        <button type="submit">Send Reply 🚀</button>
    </form>
</div>
<script>
    const thread = document.getElementById('thread');
    if (thread) thread.scrollTop = thread.scrollHeight;
</script>
</body>
</html>