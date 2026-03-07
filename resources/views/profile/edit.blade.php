@extends('layouts.app')

@section('title', 'الإعدادات')

@section('content')
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h2 class="h5 mb-3">معلومات الحساب</h2>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">الاسم</label>
                            <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">الهاتف</label>
                                <input name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">المدينة</label>
                                <input name="city" class="form-control" value="{{ old('city', $user->city) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">الدولة</label>
                                <input name="country" class="form-control" value="{{ old('country', $user->country) }}">
                            </div>
                        </div>

                        <button class="btn btn-primary mt-3">حفظ التعديلات</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="h5 mb-3">تغيير كلمة المرور</h2>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">كلمة المرور الحالية</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button class="btn btn-outline-primary">تحديث كلمة المرور</button>
                    </form>

                    <hr>

                    <h2 class="h6 mb-2 text-danger">حذف الحساب</h2>
                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <label class="form-label">أدخل كلمة المرور للتأكيد</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button class="btn btn-danger" onclick="return confirm('هل أنت متأكد من حذف الحساب؟')">حذف الحساب</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
