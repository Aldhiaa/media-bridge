@extends('layouts.dashboard')

@section('title', 'عروضي - Wassl')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-send ms-2"></i> العروض المقدمة</h1>
                <p>جميع العروض التي قدمتها على الحملات المختلفة</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>الحملة</th>
                        <th>الشركة</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>آخر تحديث</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $proposal)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="icon-box icon-box-primary"
                                        style="width: 36px; height: 36px; font-size: 0.8rem;">
                                        <i class="bi bi-megaphone"></i>
                                    </div>
                                    <span
                                        class="fw-bold small">{{ \Illuminate\Support\Str::limit($proposal->campaign->title, 30) }}</span>
                                </div>
                            </td>
                            <td class="small">
                                {{ $proposal->campaign->company->companyProfile->company_name ?? $proposal->campaign->company->name }}
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
                            <td class="small text-muted">{{ $proposal->updated_at->diffForHumans() }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a class="btn btn-sm btn-outline-primary"
                                        href="{{ route('agency.proposals.show', $proposal) }}" title="عرض"><i
                                            class="bi bi-eye"></i></a>
                                    @if(in_array($proposal->status->value, ['submitted', 'shortlisted']))
                                        <a class="btn btn-sm btn-outline-secondary"
                                            href="{{ route('agency.proposals.edit', $proposal) }}" title="تعديل"><i
                                                class="bi bi-pencil"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-send d-block"></i>
                                    <p>لم تقدم أي عروض بعد</p>
                                    <a href="{{ route('agency.campaigns.index') }}" class="btn btn-primary btn-sm mt-2">تصفح
                                        الحملات</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($proposals->hasPages())
            <div class="card-footer">{{ $proposals->links() }}</div>
        @endif
    </div>
@endsection