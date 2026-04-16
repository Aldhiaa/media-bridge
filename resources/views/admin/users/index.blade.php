@extends('layouts.dashboard')

@section('title', 'إدارة المستخدمين - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-people ms-2"></i> إدارة المستخدمين</h1>
        <p>إدارة حسابات المستخدمين والوكالات والشركات المسجلة</p>
    </div>

    <div class="card mb-3">
        <div class="card-body p-3">
            <form class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small text-muted">بحث</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input class="form-control" name="q" placeholder="بحث بالاسم أو البريد..." value="{{ $filters['q'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">الدور</label>
                    @php
                        $roleLabels = ['admin' => 'مدير', 'company' => 'شركة', 'agency' => 'وكالة'];
                    @endphp
                    <select class="form-select form-select-sm" name="role">
                        <option value="">كل الأدوار</option>
                        @foreach(['admin','company','agency'] as $role)
                            <option value="{{ $role }}" @selected(($filters['role'] ?? null) === $role)>{{ $roleLabels[$role] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">الحالة</label>
                    @php
                        $statusLabels = ['active' => 'نشط', 'suspended' => 'موقوف', 'pending' => 'قيد المراجعة'];
                    @endphp
                    <select class="form-select form-select-sm" name="status">
                        <option value="">كل الحالات</option>
                        @foreach(['active','suspended','pending'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? null) === $status)>{{ $statusLabels[$status] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary btn-sm w-100"><i class="bi bi-funnel ms-1"></i> فلتر</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>البريد</th>
                    <th>الدور</th>
                    <th>الحالة</th>
                    <th>التوثيق</th>
                    <th>تاريخ التسجيل</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @php
                                    $iconClass = match($user->role->value) {
                                        'admin' => 'icon-box-danger',
                                        'company' => 'icon-box-primary',
                                        'agency' => 'icon-box-accent',
                                        default => 'icon-box-primary',
                                    };
                                    $iconName = match($user->role->value) {
                                        'admin' => 'bi-shield-check',
                                        'company' => 'bi-building',
                                        'agency' => 'bi-megaphone',
                                        default => 'bi-person',
                                    };
                                @endphp
                                <div class="icon-box {{ $iconClass }}" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                    <i class="bi {{ $iconName }}"></i>
                                </div>
                                <span class="fw-bold small">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="small text-muted" dir="ltr">{{ $user->email }}</td>
                        <td>
                            @php
                                $roleBadge = match($user->role->value) {
                                    'admin' => 'badge-danger',
                                    'company' => 'badge-primary',
                                    'agency' => 'badge-warning',
                                    default => 'badge-info',
                                };
                            @endphp
                            <span class="badge badge-status {{ $roleBadge }}">{{ $user->role->label() }}</span>
                        </td>
                        <td>
                            @php
                                $sBadge = match($user->status->value) {
                                    'active' => 'badge-success',
                                    'suspended' => 'badge-danger',
                                    'pending' => 'badge-warning',
                                    default => 'badge-info',
                                };
                                $sLabel = match($user->status->value) {
                                    'active' => 'نشط',
                                    'suspended' => 'موقوف',
                                    'pending' => 'قيد المراجعة',
                                    default => $user->status->value,
                                };
                            @endphp
                            <span class="badge badge-status {{ $sBadge }}">{{ $sLabel }}</span>
                        </td>
                        <td>
                            @if($user->isAgency())
                                @if($user->agencyProfile?->is_verified)
                                    <span class="badge badge-status badge-success"><i class="bi bi-patch-check-fill ms-1"></i> موثقة</span>
                                @else
                                    <span class="badge badge-status badge-info">غير موثقة</span>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="تعديل"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="bi bi-people d-block"></i>
                                <p>لا يوجد مستخدمون</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="card-footer">{{ $users->links() }}</div>
        @endif
    </div>
@endsection
