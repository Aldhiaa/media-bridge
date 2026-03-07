@extends('layouts.app')

@section('title', 'القطاعات')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">القطاعات</h1>
        <a href="{{ route('admin.industries.create') }}" class="btn btn-primary btn-sm">إضافة قطاع</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>الاسم</th><th>الحالة</th><th></th></tr></thead>
                <tbody>
                @forelse($industries as $industry)
                    <tr>
                        <td>{{ $industry->name }}</td>
                        <td>{{ $industry->is_active ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.industries.edit', $industry) }}" class="btn btn-sm btn-outline-secondary">تعديل</a>
                            <form method="POST" action="{{ route('admin.industries.destroy', $industry) }}" class="d-inline">@csrf @method('DELETE')
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
        <div class="card-footer">{{ $industries->links() }}</div>
    </div>
@endsection
