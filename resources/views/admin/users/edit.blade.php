@extends('layouts.dashboard')

@section('title', 'تعديل مستخدم - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-person-gear ms-2"></i> تعديل المستخدم: {{ $user->name }}</h1>
        <p>تحديث دور المستخدم وحالة الحساب</p>
    </div>

    @php
        $roleLabels = ['admin' => 'مدير', 'company' => 'شركة', 'agency' => 'وكالة'];
        $statusLabels = ['active' => 'نشط', 'suspended' => 'موقوف', 'pending' => 'قيد المراجعة'];
    @endphp

    <div class="card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الدور</label>
                        <select name="role" class="form-select">
                            @foreach(['admin', 'company', 'agency'] as $role)
                                <option value="{{ $role }}" @selected($user->role->value === $role)>{{ $roleLabels[$role] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            @foreach(['active', 'suspended', 'pending'] as $status)
                                <option value="{{ $status }}" @selected($user->status->value === $status)>
                                    {{ $statusLabels[$status] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($user->isAgency() && $user->agencyProfile)
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="verified" name="is_verified" value="1"
                                    @checked($user->agencyProfile->is_verified)>
                                <label for="verified" class="form-check-label">وكالة موثقة</label>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-primary"><i class="bi bi-check-lg ms-1"></i> حفظ التغييرات</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">رجوع</a>
                </div>
            </form>
        </div>
    </div>
@endsection