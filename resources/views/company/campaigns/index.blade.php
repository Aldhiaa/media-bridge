@extends('layouts.dashboard')

@section('title', 'حملاتي - Wassl')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-megaphone ms-2"></i> إدارة الحملات</h1>
                <p>إنشاء وإدارة حملاتك الإعلانية</p>
            </div>
            <a href="{{ route('company.campaigns.create') }}" class="btn btn-accent">
                <i class="bi bi-plus-lg ms-1"></i> حملة جديدة
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
                    <label class="form-label small text-muted">الميزانية (من - إلى)</label>
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

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>الحملة</th>
                        <th>التصنيف</th>
                        <th>الميزانية</th>
                        <th>الحالة</th>
                        <th>العروض</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="icon-box icon-box-primary"
                                        style="width: 36px; height: 36px; font-size: 0.8rem;">
                                        <i class="bi bi-megaphone"></i>
                                    </div>
                                    <div>
                                        <a href="{{ route('company.campaigns.show', $campaign) }}"
                                            class="fw-bold small text-dark">{{ $campaign->title }}</a>
                                        <small
                                            class="text-muted d-block">{{ optional($campaign->proposal_deadline)->format('Y-m-d') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark"
                                    style="font-size: 0.75rem;">{{ $campaign->category?->name }}</span></td>
                            <td class="fw-bold" style="color: var(--primary);">{{ number_format((float) $campaign->budget, 0) }}
                                ر.س</td>
                            <td>
                        @php
                            $statusBadge = match ($campaign->status->value) {
                                'draft' => 'badge-info',
                                'published', 'receiving_proposals' => 'badge-success',
                                'under_review' => 'badge-warning',
                                'awarded', 'in_progress' => 'badge-primary',
                                'completed' => 'badge-success',
                                'cancelled' => 'badge-danger',
                                default => 'badge-info',
                            };
                        @endphp
                                <span class="badge badge-status {{ $statusBadge }}">{{ $campaign->status->label() }}</span>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $campaign->proposals_count }}</span>
                                <small class="text-muted">عرض</small>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a class="btn btn-sm btn-outline-primary"
                                        href="{{ route('company.campaigns.show', $campaign) }}" title="عرض"><i
                                            class="bi bi-eye"></i></a>
                                    <a class="btn btn-sm btn-outline-secondary"
                                        href="{{ route('company.campaigns.edit', $campaign) }}" title="تعديل"><i
                                            class="bi bi-pencil"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-megaphone d-block"></i>
                                    <p>لا توجد حملات حتى الآن</p>
                                    <a href="{{ route('company.campaigns.create') }}" class="btn btn-primary btn-sm mt-2">أنشئ
                                        حملتك الأولى</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($campaigns->hasPages())
            <div class="card-footer">{{ $campaigns->links() }}</div>
        @endif
    </div>
@endsection