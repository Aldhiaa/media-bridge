@extends('layouts.app')

@section('title', 'الحملات المتاحة - Media Bridge')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-search ms-2"></i> الحملات المتاحة</h1>
                <p>تصفح الحملات وقدّم أفضل عروضك</p>
            </div>
            <a href="{{ route('agency.favorites.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-bookmark-star ms-1"></i> الحملات المحفوظة
            </a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body p-3">
            <form class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small text-muted">بحث</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input name="q" class="form-control" placeholder="ابحث في الحملات..."
                            value="{{ $filters['q'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">التصنيف</label>
                    <select name="category_id" class="form-select form-select-sm">
                        <option value="">كل التصنيفات</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(($filters['category_id'] ?? null) == $category->id)>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">القطاع</label>
                    <select name="industry_id" class="form-select form-select-sm">
                        <option value="">كل القطاعات</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry->id }}" @selected(($filters['industry_id'] ?? null) == $industry->id)>
                                {{ $industry->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">الميزانية</label>
                    <div class="input-group input-group-sm">
                        <input type="number" name="budget_min" class="form-control" placeholder="من"
                            value="{{ $filters['budget_min'] ?? '' }}">
                        <input type="number" name="budget_max" class="form-control" placeholder="إلى"
                            value="{{ $filters['budget_max'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary btn-sm w-100"><i class="bi bi-funnel ms-1"></i> فلتر</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        @forelse($campaigns as $campaign)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            @php
                                $statusBadge = match ($campaign->status->value) {
                                    'published', 'receiving_proposals' => 'badge-success',
                                    'under_review' => 'badge-warning',
                                    default => 'badge-info',
                                };
                            @endphp
                            <span class="badge badge-status {{ $statusBadge }}">
                                <i class="bi bi-circle-fill ms-1" style="font-size: 0.45rem;"></i>
                                {{ $campaign->status->label() }}
                            </span>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 ms-1"></i> {{ $campaign->proposal_deadline?->format('Y-m-d') }}
                            </small>
                        </div>
                        <h2 class="h6 fw-bold mb-2">{{ $campaign->title }}</h2>
                        <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($campaign->description, 100) }}</p>

                        <div class="d-flex justify-content-between align-items-center pt-2 mb-3"
                            style="border-top: 1px solid var(--border-light);">
                            <div>
                                <small class="text-muted">الميزانية</small>
                                <div class="fw-bold" style="color: var(--primary);">
                                    {{ number_format((float) $campaign->budget, 0) }} ر.س</div>
                            </div>
                            @if($campaign->category)
                                <span class="badge bg-light text-dark"
                                    style="font-size: 0.75rem;">{{ $campaign->category->name }}</span>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <a class="btn btn-sm btn-primary flex-grow-1"
                                href="{{ route('agency.campaigns.show', $campaign) }}">
                                <i class="bi bi-eye ms-1"></i> التفاصيل
                            </a>
                            @if(in_array($campaign->id, $favoriteIds, true))
                                <form method="POST" action="{{ route('agency.campaigns.unfavorite', $campaign) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-warning" title="إزالة من المحفوظات"><i
                                            class="bi bi-bookmark-fill"></i></button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('agency.campaigns.favorite', $campaign) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-warning" title="حفظ الحملة"><i
                                            class="bi bi-bookmark"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-search d-block"></i>
                    <p>لا توجد حملات متاحة حالياً</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($campaigns->hasPages())
        <div class="mt-3">{{ $campaigns->links() }}</div>
    @endif
@endsection