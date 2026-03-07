@extends('layouts.app')
@section('title', 'الباقات - Media Bridge')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-credit-card ms-2"></i> باقات المنصة</h1>
        <p>اختر الباقة المناسبة لاحتياجاتك</p>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 p-4 text-center">
                <div class="icon-box icon-box-primary mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem;">
                    <i class="bi bi-rocket"></i>
                </div>
                <h3 class="h5 fw-bold">مجاني</h3>
                <div class="h2 fw-bold my-3" style="color: var(--primary);">0 <small class="h6 text-muted">ر.س/شهر</small>
                </div>
                <ul class="list-unstyled text-start mb-4" style="font-size: 0.9rem;">
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--primary);"></i> إنشاء حساب
                        شركة أو وكالة</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--primary);"></i> نشر حتى 3
                        حملات شهرياً</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--primary);"></i> تقديم عروض
                        غير محدودة</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--primary);"></i> نظام
                        المحادثات</li>
                    <li class="mb-2 text-muted"><i class="bi bi-x-circle ms-2"></i> تمييز الحملات</li>
                    <li class="mb-2 text-muted"><i class="bi bi-x-circle ms-2"></i> تقارير متقدمة</li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">ابدأ مجاناً</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 p-4 text-center position-relative" style="border: 2px solid var(--primary);">
                <div class="position-absolute top-0 start-50 translate-middle">
                    <span class="badge btn-accent px-3 py-2">الأكثر شعبية</span>
                </div>
                <div class="icon-box mx-auto mb-3"
                    style="width: 64px; height: 64px; font-size: 1.5rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff;">
                    <i class="bi bi-gem"></i>
                </div>
                <h3 class="h5 fw-bold">احترافي</h3>
                <div class="h2 fw-bold my-3" style="color: var(--primary);">199 <small class="h6 text-muted">ر.س/شهر</small>
                </div>
                <ul class="list-unstyled text-start mb-4" style="font-size: 0.9rem;">
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--primary);"></i> جميع مزايا
                        الباقة المجانية</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--primary);"></i> حملات غير
                        محدودة</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--primary);"></i> تمييز
                        الحملات في الصفحة الرئيسية</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--primary);"></i> تقارير أداء
                        متقدمة</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--primary);"></i> دعم أولوية
                    </li>
                    <li class="mb-2 text-muted"><i class="bi bi-x-circle ms-2"></i> مدير حساب مخصص</li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-primary w-100">اشترك الآن</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 p-4 text-center">
                <div class="icon-box icon-box-accent mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem;">
                    <i class="bi bi-crown"></i>
                </div>
                <h3 class="h5 fw-bold">المؤسسات</h3>
                <div class="h2 fw-bold my-3" style="color: var(--accent-dark);">499 <small
                        class="h6 text-muted">ر.س/شهر</small></div>
                <ul class="list-unstyled text-start mb-4" style="font-size: 0.9rem;">
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--accent-dark);"></i> جميع
                        المزايا الاحترافية</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--accent-dark);"></i> مدير
                        حساب مخصص</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--accent-dark);"></i> API
                        مخصص</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--accent-dark);"></i> تخصيص
                        الهوية البصرية</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--accent-dark);"></i> SLA
                        ضمان وقت التشغيل</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill ms-2" style="color: var(--accent-dark);"></i> تقارير
                        شهرية تفصيلية</li>
                </ul>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary w-100">تواصل معنا</a>
            </div>
        </div>
    </div>
@endsection