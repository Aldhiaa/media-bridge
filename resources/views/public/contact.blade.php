@extends('layouts.app')
@section('title', 'تواصل معنا - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-envelope ms-2"></i> تواصل معنا</h1>
        <p>نسعد بتواصلك معنا للاستفسارات والاقتراحات</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card p-4">
                <h2 class="h5 fw-bold mb-3">أرسل لنا رسالة</h2>
                <form method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم الكامل</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', auth()->user()->name ?? '') }}" required placeholder="أدخل اسمك الكامل">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', auth()->user()->email ?? '') }}" required placeholder="email@example.com"
                            dir="ltr">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">الرسالة</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required
                            placeholder="اكتب رسالتك هنا...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send ms-1"></i> إرسال الرسالة
                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card p-4 mb-3">
                <h3 class="h6 fw-bold mb-3">معلومات التواصل</h3>
                <div class="d-flex gap-3 mb-3">
                    <div class="icon-box icon-box-primary" style="min-width: 42px; height: 42px; font-size: 1rem;">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">البريد الإلكتروني</small>
                        <span class="fw-bold small" dir="ltr">support@mediabridge.sa</span>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-3">
                    <div class="icon-box icon-box-accent" style="min-width: 42px; height: 42px; font-size: 1rem;">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">الموقع</small>
                        <span class="fw-bold small">المملكة العربية السعودية</span>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="icon-box icon-box-info" style="min-width: 42px; height: 42px; font-size: 1rem;">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">ساعات العمل</small>
                        <span class="fw-bold small">الأحد - الخميس، 9 ص - 5 م</span>
                    </div>
                </div>
            </div>
            <div class="card p-4">
                <h3 class="h6 fw-bold mb-3">تابعنا</h3>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-twitter-x"></i> تويتر</a>
                    <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-linkedin"></i> لينكدإن</a>
                    <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-instagram"></i> إنستقرام</a>
                </div>
            </div>
        </div>
    </div>
@endsection