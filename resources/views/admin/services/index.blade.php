@extends('layouts.app')

@section('title', 'الخدمات')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">الخدمات</h1>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">إضافة خدمة</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>الاسم</th><th>الحالة</th><th></th></tr></thead>
                <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->is_active ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-secondary">تعديل</a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="d-inline">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3"><div class="text-center p-3 text-muted">لا توجد عناصر.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $services->links() }}</div>
    </div>
@endsection
