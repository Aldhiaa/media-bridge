@extends('layouts.dashboard')

@section('title', 'المحادثات - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-chat-dots ms-2"></i> المحادثات</h1>
        <p>جميع محادثاتك مع الشركات والوكالات</p>
    </div>

    <div class="row g-3">
        @forelse($conversations as $conversation)
            @php
                $otherParty = auth()->id() === $conversation->company_id ? $conversation->agency : $conversation->company;
            @endphp
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-box icon-box-primary"
                                    style="width: 42px; height: 42px; border-radius: 50%; font-size: 1rem;">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div>
                                    <h2 class="h6 fw-bold mb-0">{{ $otherParty?->name }}</h2>
                                    <small class="text-muted">{{ $conversation->campaign?->title }}</small>
                                </div>
                            </div>
                            <small class="text-muted">{{ optional($conversation->last_message_at)->diffForHumans() }}</small>
                        </div>
                        <a href="{{ route('conversations.show', $conversation) }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-chat-dots ms-1"></i> فتح المحادثة
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-chat-dots d-block"></i>
                    <p>لا توجد محادثات بعد</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($conversations->hasPages())
        <div class="mt-3">{{ $conversations->links() }}</div>
    @endif
@endsection