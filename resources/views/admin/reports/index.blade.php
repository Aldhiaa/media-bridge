@extends('layouts.app')

@section('title', 'البلاغات والشكاوى - Media Bridge')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-flag ms-2"></i> البلاغات والشكاوى</h1>
        <p>إدارة البلاغات المقدمة من المستخدمين</p>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                <tr>
                    <th>النوع</th>
                    <th>الموضوع</th>
                    <th>المبلّغ</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th>تحديث الحالة</th>
                </tr>
                </thead>
                <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>
                            <span class="badge bg-light text-dark" style="font-size: 0.75rem;">{{ $report->type }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-box" style="width: 32px; height: 32px; font-size: 0.75rem; background: #fee2e2; color: #dc2626;">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>
                                <span class="fw-bold small">{{ \Illuminate\Support\Str::limit($report->subject, 35) }}</span>
                            </div>
                        </td>
                        <td class="small">{{ $report->reporter->name }}</td>
                        <td>
                            @php
                                $rBadge = match($report->status) {
                                    'open' => 'badge-danger',
                                    'under_review' => 'badge-warning',
                                    'resolved' => 'badge-success',
                                    'dismissed' => 'badge-info',
                                    default => 'badge-info',
                                };
                                $rLabels = [
                                    'open' => 'مفتوح',
                                    'under_review' => 'قيد المراجعة',
                                    'resolved' => 'تم الحل',
                                    'dismissed' => 'مرفوض',
                                ];
                            @endphp
                            <span class="badge badge-status {{ $rBadge }}">{{ $rLabels[$report->status] ?? $report->status }}</span>
                        </td>
                        <td class="small text-muted">{{ $report->created_at->format('Y-m-d') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.reports.status', $report) }}" class="d-flex gap-1">
                                @csrf @method('PUT')
                                @php
                                    $sLabels = [
                                        'open' => 'مفتوح',
                                        'under_review' => 'قيد المراجعة',
                                        'resolved' => 'تم الحل',
                                        'dismissed' => 'مرفوض',
                                    ];
                                @endphp
                                <select name="status" class="form-select form-select-sm" style="width: auto;">
                                    @foreach(['open','under_review','resolved','dismissed'] as $status)
                                        <option value="{{ $status }}" @selected($report->status === $status)>{{ $sLabels[$status] }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-primary"><i class="bi bi-check-lg"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-check-circle d-block" style="color: var(--primary);"></i>
                                <p>لا توجد بلاغات مسجلة</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
            <div class="card-footer">{{ $reports->links() }}</div>
        @endif
    </div>
@endsection
