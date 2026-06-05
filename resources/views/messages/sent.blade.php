@extends('layouts.app')

@section('title', 'Sent')

@section('extra_css')
<style>
    .tg-msg-side .list-group-item { border:none; border-radius:12px !important; margin-bottom:6px; font-weight:600; color:#4a5a55; }
    .tg-msg-side .list-group-item.active { background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); color:#fff; }
    .tg-thread { background:#fff; border-radius:14px; padding:16px 18px; margin-bottom:10px; display:block;
        text-decoration:none; color:inherit; box-shadow:0 3px 12px rgba(0,0,0,.04); transition:transform .2s, box-shadow .2s; }
    .tg-thread:hover { transform:translateX(4px); box-shadow:0 8px 20px rgba(0,0,0,.08); color:inherit; }
    .tg-thread-avatar { width:48px;height:48px;border-radius:50%; background:linear-gradient(135deg,var(--tg-green),var(--tg-light));
        color:#fff; display:flex;align-items:center;justify-content:center; font-weight:700; flex:0 0 48px; }
    .tg-empty { background:#fff; border-radius:18px; padding:56px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.05); }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <h2 class="section-title mb-4"><i class="fas fa-comments me-2"></i>Messages</h2>
    <div class="row g-4">
        <div class="col-md-3 tg-msg-side">
            <div class="list-group">
                <a href="{{ route('messages.inbox') }}" class="list-group-item list-group-item-action"><i class="fas fa-inbox me-2"></i> Conversations</a>
                <a href="{{ route('messages.sent') }}" class="list-group-item list-group-item-action active"><i class="fas fa-paper-plane me-2"></i> Sent</a>
            </div>
        </div>

        <div class="col-md-9">
            @if ($threads->isEmpty())
                <div class="tg-empty">
                    <i class="fas fa-paper-plane fa-2x text-muted mb-3"></i>
                    <h5>No sent messages yet</h5>
                    <p class="text-muted mb-0">Reach out to a neighbor from any food or skill post.</p>
                </div>
            @else
                @foreach ($threads as $thread)
                    <a href="{{ route('messages.conversation', $thread['user']->id) }}" class="tg-thread">
                        <div class="d-flex gap-3 align-items-center">
                            @if ($thread['user']->avatar)
                                <img src="{{ asset('storage/'.$thread['user']->avatar) }}" class="tg-thread-avatar" style="object-fit:cover;" alt="">
                            @else
                                <div class="tg-thread-avatar">{{ strtoupper(substr($thread['user']->name,0,1)) }}</div>
                            @endif
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $thread['user']->name }}</strong>
                                    <small class="text-muted">{{ $thread['last']->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 text-muted small">
                                    @if ($thread['last']->sender_id === Auth::id())<span class="text-muted">You: </span>@endif
                                    {{ Str::limit($thread['last']->message, 80) }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
