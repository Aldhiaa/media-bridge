@extends('layouts.app')

@section('title', 'إنشاء حساب - Wassl')

@section('content')
    <div class="row justify-content-center py-3">
        <div class="col-md-7 col-lg-6">
            <div class="text-center mb-4">
                <div class="icon-box mx-auto mb-3"
                    style="width: 64px; height: 64px; font-size: 1.5rem; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); color: #fff;">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h1 class="h4 fw-bold">إنشاء حساب جديد</h1>
                <p class="text-muted small">سجّل حسابك للبدء في استخدام المنصة</p>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">الاسم الكامل</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input class="form-control" name="name" value="{{ old('name') }}" required
                                        placeholder="أدخل اسمك">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                        required placeholder="email@example.com" dir="ltr">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">رقم الهاتف</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input class="form-control" name="phone" value="{{ old('phone') }}" required
                                        placeholder="05xxxxxxxx" dir="ltr">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">نوع الحساب</label>
                                <select name="role" class="form-select" required>
                                    <option value="">اختر نوع الحساب</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->value }}" @selected(old('role') === $role->value)>
                                            {{ $role->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">كلمة المرور</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" class="form-control" name="password" required
                                                placeholder="••••••••">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">تأكيد كلمة المرور</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                required placeholder="••••••••">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-check-lg ms-1"></i> إنشاء الحساب
                            </button>
                        </div>
                    </form>

                    <div class="text-center pt-3" style="border-top: 1px solid var(--border-light);">
                        <small class="text-muted">لديك حساب بالفعل؟</small>
                        <a href="{{ route('login') }}" class="fw-bold" style="color: var(--primary);"> تسجيل الدخول</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection