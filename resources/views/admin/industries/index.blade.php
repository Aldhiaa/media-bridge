@extends('layouts.dashboard')

@section('title', 'القطاعات - Media Bridge')

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-building ms-2"></i> القطاعات</h1>
                <p>إدارة القطاعات الصناعية والتجارية</p>
            </div>
            <a href="{{ route('admin.industries.create') }}" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg ms-1"></i> إضافة قطاع
            </a>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>القطاع</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($industries as $industry)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="icon-box icon-box-info" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <span class="fw-bold">{{ $industry->name }}</span>
                                </div>
                            </td>
                            <td>
                                @if($industry->is_active)
                                    <span class="badge badge-status badge-success"><i class="bi bi-check-circle ms-1"></i>
                                        نشط</span>
                                @else
                                    <span class="badge badge-status badge-danger"><i class="bi bi-x-circle ms-1"></i> غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.industries.edit', $industry) }}"
                                        class="btn btn-sm btn-outline-primary" title="تعديل"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.industries.destroy', $industry) }}"
                                        class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا القطاع؟')">
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
                                    <i class="bi bi-building d-block"></i>
                                    <p>لا توجد قطاعات</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($industries->hasPages())
            <div class="card-footer">{{ $industries->links() }}</div>
        @endif
    </div>
@endsection