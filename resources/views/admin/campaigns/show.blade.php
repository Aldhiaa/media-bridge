@extends('layouts.dashboard')

@section('title', 'تفاصيل حملة - Wassl')

@section('content')
    @php
        $statusLabels = [
            'draft' => 'مسودة',
            'published' => 'منشورة',
            'receiving_proposals' => 'استقبال العروض',
            'under_review' => 'قيد المراجعة',
            'awarded' => 'تم الترسية',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتملة',
            'cancelled' => 'ملغاة',
        ];
    @endphp

    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-megaphone ms-2"></i> {{ $campaign->title }}</h1>
                <p>{{ $statusLabels[$campaign->status->value] ?? $campaign->status->label() }} —
                    {{ $campaign->company->name }}</p>
            </div>
            <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-light btn-sm"><i
                    class="bi bi-arrow-right ms-1"></i> رجوع</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h3 class="h6 fw-bold" style="color: var(--primary);"><i class="bi bi-text-paragraph ms-1"></i>
                            الوصف</h3>
                        <p>{{ $campaign->description }}</p>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom"
                        style="border-color: var(--border-light) !important;">
                        <span class="text-muted small">الشركة</span>
                        <span class="fw-bold small">{{ $campaign->company->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom"
                        style="border-color: var(--border-light) !important;">
                        <span class="text-muted small">الميزانية</span>
                        <span class="fw-bold"
                            style="color: var(--primary);">{{ number_format((float) $campaign->budget, 0) }} ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small">عدد العروض</span>
                        <span class="fw-bold">{{ $campaign->proposals->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="h6 fw-bold mb-3"><i class="bi bi-arrow-repeat ms-1" style="color: var(--accent);"></i> تحديث
                        الحالة</h3>
                    <form method="POST" action="{{ route('admin.campaigns.status', $campaign) }}">
                        @csrf @method('PUT')
                        <div class="mb-2">
                            <label class="form-label small">الحالة</label>
                            <select class="form-select form-select-sm" name="status">
                                @foreach(config('marketplace.campaign_statuses') as $status)
                                    <option value="{{ $status }}" @selected($campaign->status->value === $status)>
                                        {{ $statusLabels[$status] ?? $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="featured" name="is_featured" value="1"
                                @checked($campaign->is_featured)>
                            <label for="featured" class="form-check-label">إبراز في الصفحة الرئيسية</label>
                        </div>
                        <button class="btn btn-primary btn-sm w-100"><i class="bi bi-check-lg ms-1"></i> حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection