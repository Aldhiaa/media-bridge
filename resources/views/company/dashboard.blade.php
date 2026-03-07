@extends('layouts.app')

@section('title', 'لوحة الشركة - Media Bridge')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-speedometer2 ms-2"></i> لوحة تحكم الشركة</h1>
                <p>مرحباً {{ auth()->user()->name }}، إليك ملخص نشاطك على المنصة</p>
            </div>
            <a href="{{ route('company.campaigns.create') }}" class="btn btn-accent">
                <i class="bi bi-plus-lg ms-1"></i> حملة جديدة
            </a>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-gradient-1">
                <div class="stat-icon"><i class="bi bi-megaphone"></i></div>
                <div class="stat-value">{{ $totalCampaigns }}</div>
                <div class="stat-label">إجمالي الحملات</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-gradient-2">
                <div class="stat-icon"><i class="bi bi-broadcast"></i></div>
                <div class="stat-value">{{ $activeCampaigns }}</div>
                <div class="stat-label">الحملات النشطة</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-gradient-3">
                <div class="stat-icon"><i class="bi bi-collection"></i></div>
                <div class="stat-value">{{ $proposalsReceived }}</div>
                <div class="stat-label">العروض المستلمة</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-gradient-4">
                <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                <div class="stat-value">{{ $acceptedProposals }}</div>
                <div class="stat-label">العروض المقبولة</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- LATEST CAMPAIGNS --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-bold mb-0"><i class="bi bi-clock-history ms-2" style="color: var(--primary);"></i>
                            آخر تحديثات الحملات</h2>
                        <a href="{{ route('company.campaigns.index') }}" class="btn btn-outline-primary btn-sm">عرض الكل</a>
                    </div>
                    @forelse($latestUpdates as $campaign)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}"
                            style="border-color: var(--border-light) !important;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-box icon-box-primary" style="width: 36px; height: 36px; font-size: 0.85rem;">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                                <a href="{{ route('company.campaigns.show', $campaign) }}"
                                    class="fw-bold small text-dark">{{ \Illuminate\Support\Str::limit($campaign->title, 35) }}</a>
                            </div>
                            <span class="badge badge-status badge-info">{{ $campaign->status->label() }}</span>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-megaphone d-block" style="font-size: 2rem;"></i>
                            <p class="small">لا توجد حملات حتى الآن</p>
                            <a href="{{ route('company.campaigns.create') }}" class="btn btn-primary btn-sm">أنشئ حملتك
                                الأولى</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- RECENT MESSAGES --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-bold mb-0"><i class="bi bi-chat-dots ms-2" style="color: var(--accent);"></i> أحدث
                            المحادثات</h2>
                        <a href="{{ route('conversations.index') }}" class="btn btn-outline-primary btn-sm">عرض الكل</a>
                    </div>
                    @forelse($recentMessages as $conversation)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}"
                            style="border-color: var(--border-light) !important;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-box icon-box-accent" style="width: 36px; height: 36px; font-size: 0.85rem;">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <a href="{{ route('conversations.show', $conversation) }}"
                                    class="fw-bold small text-dark">{{ \Illuminate\Support\Str::limit($conversation->campaign?->title, 35) }}</a>
                            </div>
                            <small class="text-muted">{{ optional($conversation->last_message_at)->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-chat-dots d-block" style="font-size: 2rem;"></i>
                            <p class="small">لا توجد رسائل جديدة</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection