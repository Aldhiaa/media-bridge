@extends('layouts.dashboard')

@section('title', $campaign->title . ' - Media Bridge')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1><i class="bi bi-megaphone ms-2"></i> {{ $campaign->title }}</h1>
                <p>{{ $campaign->category?->name }} — {{ $campaign->status->label() }}</p>
            </div>
            <div class="d-flex gap-2">
                @if($isFavorited)
                    <form method="POST" action="{{ route('agency.campaigns.unfavorite', $campaign) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-warning btn-sm"><i class="bi bi-bookmark-fill ms-1"></i> محفوظة</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('agency.campaigns.favorite', $campaign) }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm"><i class="bi bi-bookmark ms-1"></i> حفظ الحملة</button>
                    </form>
                @endif
                <a href="{{ route('agency.campaigns.index') }}" class="btn btn-outline-light btn-sm"><i
                        class="bi bi-arrow-right ms-1"></i> رجوع</a>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- CAMPAIGN DETAILS --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @php
                            $statusBadge = match ($campaign->status->value) {
                                'published', 'receiving_proposals' => 'badge-success',
                                'under_review' => 'badge-warning',
                                default => 'badge-info',
                            };
                        @endphp
                        <span class="badge badge-status {{ $statusBadge }}"><i class="bi bi-circle-fill ms-1"
                                style="font-size: 0.5rem;"></i> {{ $campaign->status->label() }}</span>
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
                        <span class="text-muted small">الشركة</span>
                        <span
                            class="fw-bold small">{{ $campaign->company->companyProfile->company_name ?? $campaign->company->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom"
                        style="border-color: var(--border-light) !important;">
                        <span class="text-muted small">الميزانية</span>
                        <span class="fw-bold"
                            style="color: var(--primary);">{{ number_format((float) $campaign->budget, 0) }} ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small">آخر موعد للعروض</span>
                        <span class="fw-bold small text-danger">{{ $campaign->proposal_deadline?->format('Y-m-d') }}</span>
                    </div>
                </div>
            </div>

            @if($myProposal)
                <div class="card" style="border: 2px solid var(--primary);">
                    <div class="card-body text-center p-3">
                        <div class="icon-box icon-box-primary mx-auto mb-2"
                            style="width: 48px; height: 48px; font-size: 1.1rem;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <p class="fw-bold small mb-2">لقد أرسلت عرضاً لهذه الحملة</p>
                        <a href="{{ route('agency.proposals.show', $myProposal) }}"
                            class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-eye ms-1"></i> عرض طلبي
                        </a>
                    </div>
                </div>
            @else
                <a href="{{ route('agency.proposals.create', $campaign) }}" class="btn btn-accent w-100 btn-lg">
                    <i class="bi bi-send ms-1"></i> تقديم عرض
                </a>
            @endif
        </div>
    </div>
@endsection