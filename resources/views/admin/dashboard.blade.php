@extends('layouts.app')

@section('title', 'لوحة الإدارة - Media Bridge')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1><i class="bi bi-gear ms-2"></i> لوحة تحكم الإدارة</h1>
                <p>إدارة شاملة للمنصة والمستخدمين والحملات</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm"><i
                        class="bi bi-people ms-1"></i> المستخدمون</a>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-light btn-sm"><i
                        class="bi bi-flag ms-1"></i> البلاغات</a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-light btn-sm"><i
                        class="bi bi-sliders ms-1"></i> الإعدادات</a>
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg">
            <div class="stat-card stat-gradient-1">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div class="stat-value">{{ $totals['users'] }}</div>
                <div class="stat-label">إجمالي المستخدمين</div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="stat-card stat-gradient-2">
                <div class="stat-icon"><i class="bi bi-building"></i></div>
                <div class="stat-value">{{ $totals['companies'] }}</div>
                <div class="stat-label">الشركات</div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="stat-card stat-gradient-3">
                <div class="stat-icon"><i class="bi bi-megaphone"></i></div>
                <div class="stat-value">{{ $totals['agencies'] }}</div>
                <div class="stat-label">الوكالات</div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="stat-card stat-gradient-4">
                <div class="stat-icon"><i class="bi bi-broadcast"></i></div>
                <div class="stat-value">{{ $totals['campaigns'] }}</div>
                <div class="stat-label">الحملات</div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="stat-card stat-gradient-5">
                <div class="stat-icon"><i class="bi bi-collection"></i></div>
                <div class="stat-value">{{ $totals['proposals'] }}</div>
                <div class="stat-label">العروض</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- MOST ACTIVE USERS --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-bold mb-0"><i class="bi bi-star ms-2" style="color: var(--accent);"></i> أكثر
                            المستخدمين نشاطاً</h2>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm">عرض الكل</a>
                    </div>
                    @foreach($mostActiveUsers as $user)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}"
                            style="border-color: var(--border-light) !important;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-box {{ $user->role === \App\Enums\Role::Company ? 'icon-box-primary' : 'icon-box-accent' }}"
                                    style="width: 36px; height: 36px; font-size: 0.8rem;">
                                    <i
                                        class="bi {{ $user->role === \App\Enums\Role::Company ? 'bi-building' : 'bi-megaphone' }}"></i>
                                </div>
                                <div>
                                    <span class="fw-bold small">{{ $user->name }}</span>
                                    <span
                                        class="badge badge-status {{ $user->role === \App\Enums\Role::Company ? 'badge-primary' : 'badge-warning' }}"
                                        style="font-size: 0.7rem;">{{ $user->role->label() }}</span>
                                </div>
                            </div>
                            <div class="text-end small">
                                <span class="text-muted">حملات: {{ $user->campaigns_count }}</span>
                                <span class="text-muted me-2">عروض: {{ $user->proposals_count }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- LATEST REPORTS --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-bold mb-0"><i class="bi bi-flag ms-2" style="color: #ef4444;"></i> أحدث البلاغات
                        </h2>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary btn-sm">عرض الكل</a>
                    </div>
                    @forelse($latestReports as $report)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}"
                            style="border-color: var(--border-light) !important;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-box"
                                    style="width: 36px; height: 36px; font-size: 0.8rem; background: #fee2e2; color: #dc2626;">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <span
                                        class="fw-bold small">{{ \Illuminate\Support\Str::limit($report->subject, 35) }}</span>
                                    <small class="text-muted d-block">{{ $report->reporter?->name }}</small>
                                </div>
                            </div>
                            @php
                                $reportBadge = match ($report->status) {
                                    'open' => 'badge-danger',
                                    'under_review' => 'badge-warning',
                                    'resolved' => 'badge-success',
                                    default => 'badge-info',
                                };
                                $reportLabel = match ($report->status) {
                                    'open' => 'مفتوح',
                                    'under_review' => 'قيد المراجعة',
                                    'resolved' => 'تم الحل',
                                    default => $report->status,
                                };
                            @endphp
                            <span class="badge badge-status {{ $reportBadge }}">{{ $reportLabel }}</span>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-check-circle d-block" style="font-size: 2rem; color: var(--primary);"></i>
                            <p class="small">لا توجد بلاغات جديدة</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- RECENT ACTIVITY --}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="h6 fw-bold mb-3"><i class="bi bi-activity ms-2" style="color: var(--primary);"></i> النشاط
                        الأخير</h2>
                    <div class="row g-2">
                        @foreach($recentActivity as $activity)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 py-1">
                                    @php
                                        $actIcon = match ($activity['type']) {
                                            'campaign' => ['bi-megaphone', 'icon-box-primary'],
                                            'proposal' => ['bi-send', 'icon-box-accent'],
                                            'message' => ['bi-chat-dots', 'icon-box-info'],
                                            default => ['bi-circle', 'icon-box-primary'],
                                        };
                                    @endphp
                                    <div class="icon-box {{ $actIcon[1] }}"
                                        style="width: 30px; height: 30px; font-size: 0.75rem; border-radius: 50%;">
                                        <i class="bi {{ $actIcon[0] }}"></i>
                                    </div>
                                    <span class="small">{{ $activity['label'] }}</span>
                                    <small class="text-muted me-auto">{{ $activity['date']->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection