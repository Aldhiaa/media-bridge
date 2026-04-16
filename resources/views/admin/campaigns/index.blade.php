@extends('layouts.dashboard')

@section('title', 'مراقبة الحملات - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-broadcast ms-2"></i> مراقبة الحملات</h1>
        <p>عرض جميع الحملات المسجلة في المنصة</p>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>الحملة</th>
                        <th>الشركة</th>
                        <th>الحالة</th>
                        <th>الميزانية</th>
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
                                    <span
                                        class="fw-bold small">{{ \Illuminate\Support\Str::limit($campaign->title, 35) }}</span>
                                </div>
                            </td>
                            <td class="small">{{ $campaign->company->name }}</td>
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
                            <td class="fw-bold" style="color: var(--primary);">{{ number_format((float) $campaign->budget, 0) }}
                                ر.س</td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.campaigns.show', $campaign) }}"
                                    title="تفاصيل"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-broadcast d-block"></i>
                                    <p>لا توجد حملات</p>
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