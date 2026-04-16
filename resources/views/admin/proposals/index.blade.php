@extends('layouts.dashboard')

@section('title', 'مراقبة العروض - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-collection ms-2"></i> مراقبة العروض</h1>
        <p>جميع العروض المقدمة على حملات المنصة</p>
    </div>

    @php
        $statusLabels = [
            'submitted' => 'مقدّم',
            'shortlisted' => 'في القائمة المختصرة',
            'accepted' => 'مقبول',
            'rejected' => 'مرفوض',
        ];
        $statusBadges = [
            'submitted' => 'badge-info',
            'shortlisted' => 'badge-warning',
            'accepted' => 'badge-success',
            'rejected' => 'badge-danger',
        ];
    @endphp

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الحملة</th>
                        <th>الوكالة</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $proposal)
                        <tr>
                            <td class="small text-muted">{{ $proposal->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="icon-box icon-box-primary"
                                        style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        <i class="bi bi-megaphone"></i>
                                    </div>
                                    <span
                                        class="fw-bold small">{{ \Illuminate\Support\Str::limit($proposal->campaign->title, 30) }}</span>
                                </div>
                            </td>
                            <td class="small">{{ $proposal->agency->name }}</td>
                            <td class="fw-bold" style="color: var(--primary);">
                                {{ number_format((float) $proposal->proposed_price, 0) }} ر.س</td>
                            <td>
                                <span class="badge badge-status {{ $statusBadges[$proposal->status->value] ?? 'badge-info' }}">
                                    {{ $statusLabels[$proposal->status->value] ?? $proposal->status->label() }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.proposals.show', $proposal) }}" class="btn btn-sm btn-outline-primary"
                                    title="تفاصيل"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-collection d-block"></i>
                                    <p>لا توجد عروض</p>
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