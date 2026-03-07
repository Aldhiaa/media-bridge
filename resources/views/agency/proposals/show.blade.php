@extends('layouts.dashboard')

@section('title', 'تفاصيل العرض - Media Bridge')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1><i class="bi bi-file-text ms-2"></i> تفاصيل العرض</h1>
                <p>عرضك على حملة: {{ $proposal->campaign->title }}</p>
            </div>
            <div class="d-flex gap-2">
                @if(in_array($proposal->status->value, ['submitted', 'shortlisted']))
                    <a href="{{ route('agency.proposals.edit', $proposal) }}" class="btn btn-outline-light btn-sm"><i
                            class="bi bi-pencil ms-1"></i> تعديل</a>
                @endif
                <a href="{{ route('agency.proposals.index') }}" class="btn btn-outline-light btn-sm"><i
                        class="bi bi-arrow-right ms-1"></i> رجوع</a>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h3 class="h6 fw-bold" style="color: var(--primary);"><i class="bi bi-lightbulb ms-1"></i>
                            الاستراتيجية المقترحة</h3>
                        <p>{{ $proposal->strategy_summary }}</p>
                    </div>

                    <div class="mb-3">
                        <h3 class="h6 fw-bold" style="color: var(--primary);"><i class="bi bi-briefcase ms-1"></i> الخبرة
                            ذات الصلة</h3>
                        <p>{{ $proposal->relevant_experience }}</p>
                    </div>

                    @if($proposal->notes)
                        <div>
                            <h3 class="h6 fw-bold" style="color: var(--primary);"><i class="bi bi-sticky ms-1"></i> ملاحظات
                                إضافية</h3>
                            <p class="mb-0">{{ $proposal->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($proposal->attachments->count())
                <div class="card mt-3">
                    <div class="card-body">
                        <h3 class="h6 fw-bold"><i class="bi bi-paperclip ms-1" style="color: var(--primary);"></i> مرفقات العرض
                        </h3>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($proposal->attachments as $attachment)
                                <a target="_blank" href="{{ asset('storage/' . $attachment->file_path) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-file-earmark ms-1"></i> {{ $attachment->original_name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="h6 fw-bold mb-3"><i class="bi bi-info-circle ms-1" style="color: var(--primary);"></i> بيانات
                        العرض</h3>
                    <div class="d-flex justify-content-between py-2 border-bottom"
                        style="border-color: var(--border-light) !important;">
                        <span class="text-muted small">السعر المقترح</span>
                        <span class="fw-bold"
                            style="color: var(--primary);">{{ number_format((float) $proposal->proposed_price, 0) }}
                            ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom"
                        style="border-color: var(--border-light) !important;">
                        <span class="text-muted small">مدة التنفيذ</span>
                        <span class="fw-bold small">{{ $proposal->execution_timeline }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom"
                        style="border-color: var(--border-light) !important;">
                        <span class="text-muted small">الحالة</span>
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
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small">آخر تحديث</span>
                        <span class="small">{{ $proposal->updated_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>

            @if(in_array($proposal->status->value, ['submitted', 'shortlisted']))
                <form method="POST" action="{{ route('agency.proposals.destroy', $proposal) }}"
                    onsubmit="return confirm('هل أنت متأكد من سحب هذا العرض؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100"><i class="bi bi-x-circle ms-1"></i> سحب العرض</button>
                </form>
            @endif
        </div>
    </div>
@endsection