@extends('layouts.dashboard')

@section('title', 'الإشعارات - Wassl')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-bell ms-2"></i> الإشعارات</h1>
            <p>جميع إشعاراتك ومستجداتك</p>
        </div>
        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            <button class="btn btn-outline-light btn-sm"><i class="bi bi-check-all ms-1"></i> تعليم الكل كمقروء</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>الإشعار</th>
                    <th>التفاصيل</th>
                    <th>التاريخ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                @php($data = $notification->data)
                <tr class="{{ $notification->read_at ? '' : 'table-warning' }}">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box {{ $notification->read_at ? 'icon-box-primary' : 'icon-box-accent' }}"
                                style="width: 32px; height: 32px; font-size: 0.75rem;">
                                <i class="bi bi-bell{{ $notification->read_at ? '' : '-fill' }}"></i>
                            </div>
                            <span class="fw-bold small">{{ $data['title'] ?? 'إشعار جديد' }}</span>
                        </div>
                    </td>
                    <td class="small text-muted">{{ $data['body'] ?? '' }}</td>
                    <td class="small text-muted">{{ $notification->created_at->diffForHumans() }}</td>
                    <td class="text-nowrap">
                        <div class="d-flex gap-1">
                            @if(!empty($data['url']))
                                <a href="{{ $data['url'] }}" class="btn btn-sm btn-outline-primary" title="فتح"><i
                                        class="bi bi-box-arrow-up-left"></i></a>
                            @endif
                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-primary" title="تمت القراءة"><i
                                            class="bi bi-check-lg"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="bi bi-bell-slash d-block"></i>
                            <p>لا توجد إشعارات</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($notifications->hasPages())
        <div class="card-footer">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection