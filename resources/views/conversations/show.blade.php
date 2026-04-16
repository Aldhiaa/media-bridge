@extends('layouts.dashboard')

@section('title', 'محادثة - Wassl')

@push('styles')
    <style>
        .chat-container {
            max-height: 450px;
            overflow-y: auto;
            padding: 1rem;
        }

        .chat-bubble {
            max-width: 75%;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-lg);
            margin-bottom: 0.5rem;
            position: relative;
        }

        .chat-mine {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            margin-left: auto;
            border-bottom-left-radius: 4px;
        }

        .chat-theirs {
            background: var(--surface-alt);
            color: var(--text);
            border: 1px solid var(--border-light);
            border-bottom-right-radius: 4px;
        }

        .chat-meta {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-top: 0.25rem;
        }

        .chat-mine .chat-meta {
            color: rgba(255, 255, 255, 0.6);
        }
    </style>
@endpush

@section('content')
    @php
        $otherParty = auth()->id() === $conversation->company_id ? $conversation->agency : $conversation->company;
    @endphp

    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box icon-box-primary"
                    style="width: 42px; height: 42px; border-radius: 50%; font-size: 1rem;">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <h1 class="h6 fw-bold mb-0">{{ $otherParty?->name }}</h1>
                    <small class="text-muted">حملة: {{ $conversation->campaign?->title }}</small>
                </div>
            </div>
            <a href="{{ route('conversations.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-right ms-1"></i> رجوع
            </a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="chat-container" id="chatContainer">
            @forelse($messages as $message)
                <div
                    class="d-flex flex-column {{ $message->sender_id === auth()->id() ? 'align-items-start' : 'align-items-end' }}">
                    <div class="chat-bubble {{ $message->sender_id === auth()->id() ? 'chat-mine' : 'chat-theirs' }}">
                        <div class="fw-bold small mb-1">{{ $message->sender->name }}</div>
                        <div>{{ $message->body }}</div>
                        @if($message->attachment_path)
                            <div class="mt-2">
                                <a class="btn btn-sm {{ $message->sender_id === auth()->id() ? 'btn-outline-light' : 'btn-outline-primary' }}"
                                    target="_blank" href="{{ asset('storage/' . $message->attachment_path) }}">
                                    <i class="bi bi-paperclip ms-1"></i> تحميل مرفق
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="chat-meta {{ $message->sender_id === auth()->id() ? 'text-start' : 'text-end' }}">
                        {{ $message->created_at->format('Y-m-d H:i') }}
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-chat-dots d-block" style="font-size: 2rem;"></i>
                    <p class="small">ابدأ المحادثة بإرسال أول رسالة</p>
                </div>
            @endforelse
        </div>
        @if($messages->hasPages())
            <div class="card-footer">{{ $messages->links() }}</div>
        @endif
    </div>

    <div class="card">
        <div class="card-body p-3">
            <form method="POST" action="{{ route('conversations.messages.store', $conversation) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="d-flex gap-2 align-items-end">
                    <div class="flex-grow-1">
                        <textarea name="body" class="form-control" rows="2" placeholder="اكتب رسالتك..."
                            required>{{ old('body') }}</textarea>
                    </div>
                    <div class="d-flex gap-1">
                        <label class="btn btn-outline-secondary" title="إرفاق ملف" style="cursor: pointer;">
                            <i class="bi bi-paperclip"></i>
                            <input type="file" name="attachment" class="d-none">
                        </label>
                        <button class="btn btn-primary"><i class="bi bi-send"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-scroll chat to bottom
        const chat = document.getElementById('chatContainer');
        if (chat) chat.scrollTop = chat.scrollHeight;
    </script>
@endpush