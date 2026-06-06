@extends('layouts.app')

@section('title', __('app.messages.chat_with', ['name' => $otherUser->name]))

@section('extra_css')
<style>
    .tg-chat { max-width: 860px; margin: 0 auto; }
    .tg-chat-card { background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,.08); display:flex; flex-direction:column; height:72vh; }
    .tg-chat-head { background:linear-gradient(135deg,#16302d,#2d8f7f); color:#fff; padding:16px 22px;
        display:flex; align-items:center; justify-content:space-between; flex:0 0 auto; }
    .tg-chat-avatar { width:46px;height:46px;border-radius:50%; background:rgba(255,255,255,.2);
        color:#fff; display:flex;align-items:center;justify-content:center; font-weight:700; overflow:hidden; }
    .tg-chat-avatar img { width:100%;height:100%;object-fit:cover; }
    .tg-presence { font-size:.72rem; display:inline-flex; align-items:center; gap:5px; opacity:.85; }
    .tg-presence .dot { width:8px;height:8px;border-radius:50%; background:#7fe0cd; box-shadow:0 0 8px #7fe0cd; }
    .tg-chat-body { flex:1 1 auto; overflow-y:auto; padding:24px; background:#eef3ef;
        background-image: radial-gradient(rgba(45,143,127,.05) 1px, transparent 1px); background-size: 22px 22px; }
    .tg-day { text-align:center; margin:10px 0 16px; }
    .tg-day span { background:rgba(0,0,0,.06); color:#5a6b65; font-size:.72rem; padding:4px 12px; border-radius:20px; }
    .tg-bubble-row { display:flex; margin-bottom:12px; }
    .tg-bubble-row.me { justify-content:flex-end; }
    .tg-bubble { max-width:72%; padding:11px 15px; border-radius:18px; font-size:.95rem; line-height:1.5; word-wrap:break-word;
        animation: pop .18s ease; }
    @keyframes pop { from{transform:scale(.96);opacity:.4} to{transform:scale(1);opacity:1} }
    .tg-bubble.them { background:#fff; color:#2b3a36; border-bottom-left-radius:5px; box-shadow:0 2px 8px rgba(0,0,0,.06); }
    .tg-bubble.me { background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); color:#fff; border-bottom-right-radius:5px; }
    .tg-bubble .time { font-size:.68rem; opacity:.7; display:block; margin-top:4px; }
    .tg-chat-foot { padding:14px 18px; background:#fff; border-top:1px solid #eef1ec; flex:0 0 auto; }
    .tg-chat-foot .form-control { border-radius:24px; background:#f4f8f4; border:1.5px solid #e2e8e4; }
    .tg-send-btn { width:46px;height:46px;border-radius:50%; flex:0 0 46px; padding:0; display:flex;align-items:center;justify-content:center; }
    .tg-empty-chat { text-align:center; color:#7a8884; padding:40px 0; }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <div class="tg-chat">
        <div class="tg-chat-card">
            {{-- Header --}}
            <div class="tg-chat-head">
                <a href="{{ route('profile.show', $otherUser) }}" class="d-flex align-items-center gap-3 text-white text-decoration-none">
                    <div class="tg-chat-avatar">
                        @if ($otherUser->avatar)
                            <img src="{{ asset('storage/'.$otherUser->avatar) }}" alt="">
                        @else
                            {{ strtoupper(substr($otherUser->name,0,1)) }}
                        @endif
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $otherUser->name }}
                            @if ($otherUser->profile?->is_verified)<i class="fas fa-circle-check ms-1" style="font-size:.8rem;"></i>@endif
                        </h6>
                        <span class="tg-presence"><span class="dot"></span> ⭐ {{ number_format($otherUser->rating,1) }} · {{ $otherUser->profile?->neighborhood }}</span>
                    </div>
                </a>
                <a href="{{ route('messages.inbox') }}" class="btn btn-light btn-sm" style="border-radius:10px;"><i class="fas fa-arrow-left"></i></a>
            </div>

            {{-- Messages --}}
            <div class="tg-chat-body" id="chatBody">
                @forelse ($messages as $message)
                    <div class="tg-bubble-row {{ $message->sender_id === Auth::id() ? 'me' : 'them' }}">
                        <div class="tg-bubble {{ $message->sender_id === Auth::id() ? 'me' : 'them' }}">
                            {{ $message->message }}
                            <span class="time">{{ $message->created_at->format('M d, H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="tg-empty-chat" id="emptyChat">
                        <i class="fas fa-comments fa-3x mb-3 opacity-50"></i>
                        <p>{{ __('app.messages.no_messages') }}<br>{{ __('app.messages.say_hello', ['name' => $otherUser->name]) }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Composer --}}
            <div class="tg-chat-foot">
                <form id="chatForm" class="d-flex gap-2 align-items-center" autocomplete="off">
                    @csrf
                    <input type="text" id="chatInput" class="form-control" placeholder="{{ __('app.messages.type_message') }}" required maxlength="2000">
                    <button type="submit" class="btn btn-primary tg-send-btn"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        <p class="text-center text-muted small mt-2"><i class="fas fa-lock me-1"></i>{{ __('app.messages.private_note', ['name' => $otherUser->name]) }}</p>
    </div>
</div>

<script>
(function () {
    const body     = document.getElementById('chatBody');
    const form     = document.getElementById('chatForm');
    const input    = document.getElementById('chatInput');
    const token    = document.querySelector('#chatForm input[name="_token"]').value;
    const sendUrl  = "{{ route('messages.send', $otherUser->id) }}";
    const fetchUrl = "{{ route('messages.fetch', $otherUser->id) }}";

    let lastId = {{ $messages->last()->id ?? 0 }};
    let sending = false;
    const seen = new Set();
    @foreach ($messages as $m) seen.add({{ $m->id }}); @endforeach

    function scrollDown() { body.scrollTop = body.scrollHeight; }
    scrollDown();

    function esc(s) {
        const d = document.createElement('div'); d.textContent = s; return d.innerHTML;
    }

    function addBubble(m) {
        if (m.id && seen.has(m.id)) return;   // no duplicates
        if (m.id) seen.add(m.id);
        const empty = document.getElementById('emptyChat');
        if (empty) empty.remove();
        const row = document.createElement('div');
        row.className = 'tg-bubble-row ' + (m.mine ? 'me' : 'them');
        row.innerHTML = '<div class="tg-bubble ' + (m.mine ? 'me' : 'them') + '">' +
            esc(m.text) + '<span class="time">' + esc(m.time) + '</span></div>';
        body.appendChild(row);
        scrollDown();
    }

    // Send via AJAX
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const text = input.value.trim();
        if (!text || sending) return;
        sending = true;
        input.value = '';

        fetch(sendUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: new URLSearchParams({ message: text })
        })
        .then(r => r.json())
        .then(data => {
            if (data.ok && data.message) { addBubble(data.message); lastId = Math.max(lastId, data.message.id); }
        })
        .catch(() => { input.value = text; alert(@json(__('app.messages.send_failed'))); })
        .finally(() => { sending = false; input.focus(); });
    });

    // Poll for new incoming messages every 4s
    function poll() {
        fetch(fetchUrl + '?after=' + lastId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.messages && data.messages.length) {
                data.messages.forEach(m => { if (m.id > lastId) { addBubble(m); lastId = m.id; } });
            }
        })
        .catch(() => {});
    }
    setInterval(poll, 4000);
})();
</script>
@endsection
