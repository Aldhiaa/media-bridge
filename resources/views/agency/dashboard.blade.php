@extends('layouts.app')

@section('title', 'لوحة الوكالة - Media Bridge')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-speedometer2 ms-2"></i> لوحة تحكم الوكالة</h1>
                <p>مرحباً {{ auth()->user()->name }}، إليك ملخص نشاطك على المنصة</p>
            </div>
            <a href="{{ route('agency.campaigns.index') }}" class="btn btn-accent">
                <i class="bi bi-search ms-1"></i> تصفح الحملات
            </a>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-gradient-1">
                <div class="stat-icon"><i class="bi bi-send"></i></div>
                <div class="stat-value">{{ $totalProposals }}</div>
                <div class="stat-label">إجمالي العروض</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-gradient-3">
                <div class="stat-icon"><i class="bi bi-bookmark-star"></i></div>
                <div class="stat-value">{{ $shortlisted }}</div>
                <div class="stat-label">القائمة المختصرة</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-gradient-4">
                <div class="stat-icon"><i class="bi bi-check2-circle"></i></div>
                <div class="stat-value">{{ $accepted }}</div>
                <div class="stat-label">العروض المقبولة</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-gradient-2">
                <div class="stat-icon"><i class="bi bi-folder2-open"></i></div>
                <div class="stat-value">{{ $activeProjects }}</div>
                <div class="stat-label">المشاريع النشطة</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- MATCHING CAMPAIGNS --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-bold mb-0"><i class="bi bi-lightning ms-2" style="color: var(--accent);"></i> فرص
                            جديدة</h2>
                        <a href="{{ route('agency.campaigns.index') }}" class="btn btn-outline-primary btn-sm">عرض الكل</a>
                    </div>
                    @forelse($latestMatchingCampaigns as $campaign)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}"
                            style="border-color: var(--border-light) !important;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-box icon-box-accent" style="width: 36px; height: 36px; font-size: 0.85rem;">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                                <div>
                                    <a href="{{ route('agency.campaigns.show', $campaign) }}"
                                        class="fw-bold small text-dark d-block">{{ \Illuminate\Support\Str::limit($campaign->title, 30) }}</a>
                                    <small class="text-muted">{{ $campaign->category?->name }}</small>
                                </div>
                            </div>
                            <span
                                class="badge badge-status badge-success fw-bold">{{ number_format((float) $campaign->budget, 0) }}
                                ر.س</span>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-search d-block" style="font-size: 2rem;"></i>
                            <p class="small">لا توجد فرص جديدة حالياً</p>
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
                        <h2 class="h6 fw-bold mb-0"><i class="bi bi-chat-dots ms-2" style="color: var(--primary);"></i> آخر
                            المحادثات</h2>
                        <a href="{{ route('conversations.index') }}" class="btn btn-outline-primary btn-sm">عرض الكل</a>
                    </div>
                    @forelse($recentMessages as $conversation)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}"
                            style="border-color: var(--border-light) !important;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-box icon-box-primary" style="width: 36px; height: 36px; font-size: 0.85rem;">
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