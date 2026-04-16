@extends('layouts.dashboard')

@section('title', $campaign->title . ' - Wassl')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1><i class="bi bi-megaphone ms-2"></i> {{ $campaign->title }}</h1>
                <p>{{ $campaign->category?->name }} — {{ $campaign->status->label() }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('company.campaigns.edit', $campaign) }}" class="btn btn-outline-light btn-sm"><i
                        class="bi bi-pencil ms-1"></i> تعديل</a>
                <form method="POST" action="{{ route('company.campaigns.destroy', $campaign) }}"
                    onsubmit="return confirm('هل أنت متأكد من إلغاء هذه الحملة؟')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash ms-1"></i> إلغاء</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        {{-- CAMPAIGN DETAILS --}}
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 mb-3">
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
                        <span class="badge badge-status {{ $statusBadge }}"><i class="bi bi-circle-fill ms-1"
                                style="font-size: 0.5rem;"></i> {{ $campaign->status->label() }}</span>
                        @if($campaign->category)
                            <span class="badge bg-light text-dark">{{ $campaign->category->name }}</span>
                        @endif
                        @foreach($campaign->channels as $channel)
                            <span class="badge bg-light text-dark"><i class="bi bi-hash ms-1"></i>{{ $channel->channel }}</span>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <h3 class="h6 fw-bold" style="color: var(--primary);"><i class="bi bi-bullseye ms-1"></i> الهدف</h3>
                        <p>{{ $campaign->objective }}</p>
                    </div>

                    <div class="mb-3">
                        <h3 class="h6 fw-bold" style="color: var(--primary);"><i class="bi bi-text-paragraph ms-1"></i> وصف
                            الحملة</h3>
                        <p>{{ $campaign->description }}</p>
                    </div>

                    <div class="mb-3">
                        <h3 class="h6 fw-bold" style="color: var(--primary);"><i class="bi bi-people ms-1"></i> الجمهور
                            المستهدف</h3>
                        <p>{{ $campaign->target_audience }}</p>
                    </div>

                    <div>
                        <h3 class="h6 fw-bold" style="color: var(--primary);"><i class="bi bi-list-check ms-1"></i>
                            التسليمات المطلوبة</h3>
                        <p class="mb-0">{{ $campaign->required_deliverables }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="h6 fw-bold mb-3"><i class="bi bi-info-circle ms-1" style="color: var(--primary);"></i> تفاصيل
                        الحملة</h3>
                    <div class="d-flex justify-content-between py-2 border-bottom"
                        style="border-color: var(--border-light) !important;">
                        <span class="text-muted small">الميزانية</span>
                        <span class="fw-bold"
                            style="color: var(--primary);">{{ number_format((float) $campaign->budget, 0) }} ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom"
                        style="border-color: var(--border-light) !important;">
                        <span class="text-muted small">تاريخ البداية</span>
                        <span class="fw-bold small">{{ optional($campaign->start_date)->format('Y-m-d') ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom"
                        style="border-color: var(--border-light) !important;">
                        <span class="text-muted small">تاريخ النهاية</span>
                        <span class="fw-bold small">{{ optional($campaign->end_date)->format('Y-m-d') ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small">آخر موعد للعروض</span>
                        <span
                            class="fw-bold small text-danger">{{ optional($campaign->proposal_deadline)->format('Y-m-d') ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 class="h6 fw-bold mb-3"><i class="bi bi-arrow-repeat ms-1" style="color: var(--accent);"></i> تحديث
                        الحالة</h3>
                    <form method="POST" action="{{ route('company.campaigns.status', $campaign) }}">
                        @csrf
                        @method('PUT')
                        <select class="form-select form-select-sm mb-2" name="status">
                            @foreach(['receiving_proposals', 'under_review', 'awarded', 'in_progress', 'completed', 'cancelled'] as $status)
                                @php
                                    $statusLabels = [
                                        'receiving_proposals' => 'استقبال العروض',
                                        'under_review' => 'قيد المراجعة',
                                        'awarded' => 'تم الترسية',
                                        'in_progress' => 'قيد التنفيذ',
                                        'completed' => 'مكتملة',
                                        'cancelled' => 'ملغاة',
                                    ];
                                @endphp
                                <option value="{{ $status }}" @selected($campaign->status->value === $status)>
                                    {{ $statusLabels[$status] ?? $status }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary btn-sm w-100"><i class="bi bi-check-lg ms-1"></i> تحديث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ATTACHMENTS --}}
    @if($campaign->attachments->count())
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="h6 fw-bold"><i class="bi bi-paperclip ms-1" style="color: var(--primary);"></i> المرفقات</h3>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($campaign->attachments as $attachment)
                        <a target="_blank" href="{{ asset('storage/' . $attachment->file_path) }}"
                            class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-file-earmark ms-1"></i> {{ $attachment->original_name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- PROPOSALS TABLE --}}
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h3 class="h6 fw-bold mb-0"><i class="bi bi-collection ms-2" style="color: var(--accent);"></i> العروض المستلمة
                ({{ $proposals->count() }})</h3>
            <a href="{{ route('company.campaigns.proposals', $campaign) }}" class="btn btn-outline-primary btn-sm"><i
                    class="bi bi-columns-gap ms-1"></i> صفحة المقارنة</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>الوكالة</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>مدة التنفيذ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $proposal)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="icon-box icon-box-accent"
                                        style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <span
                                        class="fw-bold small">{{ $proposal->agency->agencyProfile->agency_name ?? $proposal->agency->name }}</span>
                                </div>
                            </td>
                            <td class="fw-bold" style="color: var(--primary);">
                                {{ number_format((float) $proposal->proposed_price, 0) }} ر.س</td>
                            <td>
                                @php
                                    $pBadge = match ($proposal->status->value) {
                                        'submitted' => 'badge-info',
                                        'shortlisted' => 'badge-warning',
                                        'accepted' => 'badge-success',
                                        'rejected' => 'badge-danger',
                                        default => 'badge-info',
                                    };
                                @endphp
                                <span class="badge badge-status {{ $pBadge }}">{{ $proposal->status->label() }}</span>
                            </td>
                            <td class="small">{{ $proposal->execution_timeline }}</td>
                            <td class="text-nowrap">
                                <div class="d-flex gap-1">
                                    <form method="POST" action="{{ route('company.proposals.shortlist', $proposal) }}"
                                        class="d-inline">@csrf<button class="btn btn-sm btn-outline-warning"
                                            title="القائمة المختصرة"><i class="bi bi-bookmark-star"></i></button></form>
                                    <form method="POST" action="{{ route('company.proposals.accept', $proposal) }}"
                                        class="d-inline">@csrf<button class="btn btn-sm btn-outline-success" title="قبول"><i
                                                class="bi bi-check-lg"></i></button></form>
                                    <form method="POST" action="{{ route('company.proposals.reject', $proposal) }}"
                                        class="d-inline">@csrf<button class="btn btn-sm btn-outline-danger" title="رفض"><i
                                                class="bi bi-x-lg"></i></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox d-block"></i>
                                    <p class="small">لا توجد عروض حتى الآن</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- REVIEW FORM --}}
    @if($campaign->status->value === 'completed')
        <div class="card">
            <div class="card-body">
                <h3 class="h6 fw-bold"><i class="bi bi-star ms-1" style="color: var(--accent);"></i> تقييم الوكالة بعد إكمال
                    الحملة</h3>
                <form method="POST" action="{{ route('company.reviews.store', $campaign) }}">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-2">
                            <label class="form-label">التقييم</label>
                            <select name="rating" class="form-select" required>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ str_repeat('⭐', $i) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-10">
                            <label class="form-label">التعليق</label>
                            <input name="comment" class="form-control" value="{{ old('comment') }}"
                                placeholder="اكتب تعليقك على أداء الوكالة...">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm mt-2"><i class="bi bi-send ms-1"></i> إرسال التقييم</button>
                </form>
            </div>
        </div>
    @endif
@endsection