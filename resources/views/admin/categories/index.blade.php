@extends('layouts.app')

@section('title', 'التصنيفات')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">التصنيفات</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">إضافة تصنيف</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>الاسم</th><th>الحالة</th><th></th></tr></thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">تعديل</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                                @csrf @method('DELETE')
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
        <div class="card-footer">{{ $categories->links() }}</div>
    </div>
@endsection
