@extends('layouts.dashboard')

@section('title', 'التصنيفات - Wassl')

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-grid ms-2"></i> التصنيفات</h1>
                <p>إدارة تصنيفات الحملات الإعلانية</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg ms-1"></i> إضافة تصنيف
            </a>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>التصنيف</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="icon-box icon-box-primary"
                                        style="width: 36px; height: 36px; font-size: 0.8rem;">
                                        <i class="bi bi-grid"></i>
                                    </div>
                                    <span class="fw-bold">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge badge-status badge-success"><i class="bi bi-check-circle ms-1"></i>
                                        نشط</span>
                                @else
                                    <span class="badge badge-status badge-danger"><i class="bi bi-x-circle ms-1"></i> غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="btn btn-sm btn-outline-primary" title="تعديل"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                        class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="حذف"><i
                                                class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <i class="bi bi-grid d-block"></i>
                                    <p>لا توجد تصنيفات</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="card-footer">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection