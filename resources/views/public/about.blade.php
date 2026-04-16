@extends('layouts.app')
@section('title', 'عن المنصة - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-info-circle ms-2"></i> عن المنصة</h1>
        <p>تعرّف على رؤيتنا ورسالتنا في تنظيم سوق التسويق الرقمي</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4">
                <h2 class="h5 fw-bold mb-3" style="color: var(--primary);">ما هي Wassl؟</h2>
                <p class="mb-3" style="line-height: 2;">
                    <strong>Wassl</strong> منصة رقمية وسيطة مبتكرة تهدف إلى تنظيم العلاقة بين الشركات والعلامات
                    التجارية من جهة، ووكالات التسويق الرقمي من جهة أخرى. نقدم بيئة احترافية تتيح للشركات طرح تفاصيل حملاتها
                    الإعلانية وميزانيتها بكل شفافية ووضوح، بينما تتنافس الوكالات لتقديم أفضل العروض من حيث السعر والفكرة
                    والخبرة.
                </p>
                <p class="mb-0" style="line-height: 2;">
                    نسعى للقضاء على العشوائية في التواصل (مثل الاعتماد على الواتساب والمعارف) وتحويله إلى سوق عمل منظم وواضح
                    يضمن للجميع الوصول لأفضل الفرص بأعلى جودة.
                </p>
            </div>

            <div class="card p-4 mt-3">
                <h2 class="h5 fw-bold mb-3" style="color: var(--primary);">أهدافنا</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex gap-3">
                            <div class="icon-box icon-box-primary" style="min-width: 42px; height: 42px; font-size: 1rem;">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold mb-1">تنظيم السوق</h3>
                                <p class="small text-muted mb-0">تنظيم سوق الحملات الإعلانية الرقمية وتسهيل الوصول للوكالات
                                    المناسبة.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-3">
                            <div class="icon-box icon-box-accent" style="min-width: 42px; height: 42px; font-size: 1rem;">
                                <i class="bi bi-eye"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold mb-1">رفع الشفافية</h3>
                                <p class="small text-muted mb-0">رفع مستوى الاحترافية والشفافية في قطاع الإعلام الإعلاني.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-3">
                            <div class="icon-box icon-box-info" style="min-width: 42px; height: 42px; font-size: 1rem;">
                                <i class="bi bi-link-45deg"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold mb-1">ربط الجهات</h3>
                                <p class="small text-muted mb-0">تسهيل عملية إنتاج المحتوى وتنسيق العروض وربط الجهات
                                    الإعلامية.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-3">
                            <div class="icon-box icon-box-purple" style="min-width: 42px; height: 42px; font-size: 1rem;">
                                <i class="bi bi-trophy"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold mb-1">منافسة عادلة</h3>
                                <p class="small text-muted mb-0">توفير بيئة تنافسية عادلة تضمن أفضل جودة بأفضل سعر.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 text-center"
                style="background: linear-gradient(135deg, var(--dark), var(--primary-dark)); color: #fff;">
                <i class="bi bi-megaphone-fill d-block mb-3" style="font-size: 3rem; color: var(--accent);"></i>
                <h3 class="h5 fw-bold">مشروع تخرج</h3>
                <p class="small" style="color: rgba(255,255,255,0.7);">
                    الجامعة السعودية الإلكترونية<br>
                    كلية العلوم والدراسات النظرية<br>
                    قسم الإعلام الإلكتروني<br>
                    المسار التطبيقي
                </p>
                <hr style="border-color: rgba(255,255,255,0.1);">
                <p class="small mb-0" style="color: rgba(255,255,255,0.5);">2026</p>
            </div>

            <div class="card p-4 mt-3">
                <h3 class="h6 fw-bold mb-3">التقنيات المستخدمة</h3>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-light text-dark p-2">HTML5</span>
                    <span class="badge bg-light text-dark p-2">CSS3</span>
                    <span class="badge bg-light text-dark p-2">JavaScript</span>
                    <span class="badge bg-light text-dark p-2">Bootstrap 5</span>
                    <span class="badge bg-light text-dark p-2">PHP</span>
                    <span class="badge bg-light text-dark p-2">Laravel</span>
                    <span class="badge bg-light text-dark p-2">MySQL</span>
                </div>
            </div>
        </div>
    </div>
@endsection