@extends('layouts.app')

@section('title', 'تعديل مستخدم')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4 mb-3">تعديل المستخدم: {{ $user->name }}</h1>
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الدور</label>
                        <select name="role" class="form-select">
                            @foreach(['admin','company','agency'] as $role)
                                <option value="{{ $role }}" @selected($user->role->value === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            @foreach(['active','suspended','pending'] as $status)
                                <option value="{{ $status }}" @selected($user->status->value === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($user->isAgency() && $user->agencyProfile)
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="verified" name="is_verified" value="1" @checked($user->agencyProfile->is_verified)>
                                <label for="verified" class="form-check-label">وكالة موثقة</label>
                            </div>
                        </div>
                    @endif
                </div>
                <button class="btn btn-primary mt-3">حفظ</button>
            </form>
        </div>
    </div>
@endsection
