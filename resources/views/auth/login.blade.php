@extends('layouts.app')

@section('title', 'تسجيل الدخول - Wassl')

@section('content')
    <div class="row justify-content-center py-3">
        <div class="col-md-6 col-lg-5">
            <div class="text-center mb-4">
                <div class="icon-box icon-box-primary mx-auto mb-3"
                    style="width: 64px; height: 64px; font-size: 1.5rem; border-radius: 50%;">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h1 class="h4 fw-bold">تسجيل الدخول</h1>
                <p class="text-muted small">أدخل بياناتك للوصول إلى حسابك على المنصة</p>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle ms-1"></i> {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required
                                    autofocus placeholder="email@example.com" dir="ltr">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" required placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">تذكرني</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="small" style="color: var(--primary);">نسيت كلمة
                                المرور؟</a>
                        </div>

                        <button class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-box-arrow-in-left ms-1"></i> تسجيل الدخول
                        </button>
                    </form>

                    <div class="text-center pt-3" style="border-top: 1px solid var(--border-light);">
                        <small class="text-muted">ليس لديك حساب؟</small>
                        <a href="{{ route('register') }}" class="fw-bold" style="color: var(--primary);"> إنشاء حساب
                            جديد</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection