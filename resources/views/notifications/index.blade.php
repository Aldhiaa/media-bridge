@extends('layouts.app')

@section('title', 'الإشعارات')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">الإشعارات</h1>
        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            <button class="btn btn-outline-primary btn-sm">تعليم الكل كمقروء</button>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                <tr>
                    <th>العنوان</th>
                    <th>التفاصيل</th>
                    <th>التاريخ</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($notifications as $notification)
                    @php($data = $notification->data)
                    <tr class="{{ $notification->read_at ? '' : 'table-warning' }}">
                        <td>{{ $data['title'] ?? 'Notification' }}</td>
                        <td>{{ $data['body'] ?? '' }}</td>
                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                        <td class="text-nowrap">
                            @if(!empty($data['url']))
                                <a href="{{ $data['url'] }}" class="btn btn-sm btn-outline-secondary">فتح</a>
                            @endif
                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">تمت القراءة</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><div class="text-center p-4 text-muted">لا توجد إشعارات.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $notifications->links() }}</div>
    </div>
@endsection
