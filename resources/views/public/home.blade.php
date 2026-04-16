@extends('layouts.app')

@section('title', 'Wassl - المنصة الوسيطة للتسويق الرقمي')
@section('meta_description', 'منصة رقمية وسيطة تربط الشركات بوكالات التسويق الرقمي لإطلاق حملات إعلانية احترافية بشفافية وكفاءة.')

@section('content')
    {{-- ===== HERO SECTION ===== --}}
    <section class="hero-section mb-4 animate-in">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="d-inline-block mb-3"
                    style="background: rgba(245,158,11,0.15); color: var(--accent); padding: 0.35rem 1rem; border-radius: 999px; font-size: 0.85rem; font-weight: 600;">
                    <i class="bi bi-stars ms-1"></i> منصة احترافية للتسويق الرقمي
                </div>
                <h1>اربط شركتك بأفضل وكالات التسويق الرقمي</h1>
                <p class="lead">انشر حملتك الإعلانية، استقبل عروضًا تنافسية من وكالات متخصصة، قارن الأسعار والخبرات، وابدأ
                    التنفيذ بشفافية كاملة — كل ذلك في مكان واحد.</p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="{{ route('register') }}" class="btn btn-accent btn-lg">
                        <i class="bi bi-rocket-takeoff ms-1"></i> ابدأ الآن مجاناً
                    </a>
                    <a href="{{ route('how-it-works') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-play-circle ms-1"></i> كيف تعمل المنصة؟
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="hero-stat-box">
                            <div class="stat-num">{{ $stats['companies'] }}+</div>
                            <div class="stat-txt">شركة مسجلة على المنصة</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="hero-stat-box">
                            <div class="stat-num">{{ $stats['agencies'] }}+</div>
                            <div class="stat-txt">وكالة تسويق</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="hero-stat-box">
                            <div class="stat-num">{{ $stats['campaigns'] }}+</div>
                            <div class="stat-txt">حملة إعلانية</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== HOW IT WORKS ===== --}}
    <section class="mb-5 animate-in animate-delay-1">
        <div class="section-header">
            <h2>كيف تعمل المنصة؟</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card text-center p-4 h-100">
                    <div class="icon-box icon-box-primary mx-auto mb-3"
                        style="width: 64px; height: 64px; font-size: 1.5rem;">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div class="badge badge-primary badge-status mx-auto mb-2">الخطوة 1</div>
                    <h3 class="h6 fw-bold">سجّل حسابك</h3>
                    <p class="small text-muted mb-0">أنشئ حسابك كشركة أو وكالة تسويق واملأ ملفك الشخصي</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-4 h-100">
                    <div class="icon-box icon-box-accent mx-auto mb-3"
                        style="width: 64px; height: 64px; font-size: 1.5rem;">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <div class="badge badge-warning badge-status mx-auto mb-2">الخطوة 2</div>
                    <h3 class="h6 fw-bold">انشر حملتك</h3>
                    <p class="small text-muted mb-0">حدد تفاصيل حملتك الإعلانية وميزانيتك بشفافية</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-4 h-100">
                    <div class="icon-box icon-box-info mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem;">
                        <i class="bi bi-collection-fill"></i>
                    </div>
                    <div class="badge badge-info badge-status mx-auto mb-2">الخطوة 3</div>
                    <h3 class="h6 fw-bold">استقبل العروض</h3>
                    <p class="small text-muted mb-0">وكالات التسويق تتنافس لتقديم أفضل عرض لك</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-4 h-100">
                    <div class="icon-box icon-box-purple mx-auto mb-3"
                        style="width: 64px; height: 64px; font-size: 1.5rem;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="badge badge-success badge-status mx-auto mb-2">الخطوة 4</div>
                    <h3 class="h6 fw-bold">اختر الأفضل</h3>
                    <p class="small text-muted mb-0">قارن العروض واختر الوكالة المناسبة وابدأ التنفيذ</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FEATURED CAMPAIGNS ===== --}}
    <section class="mb-5 animate-in animate-delay-2">
        <div class="section-header">
            <h2><i class="bi bi-fire ms-2"></i> حملات مميزة</h2>
            @auth
                @if(auth()->user()->isAgency())
                    <a href="{{ route('agency.campaigns.index') }}" class="btn btn-outline-primary btn-sm">عرض الكل <i
                            class="bi bi-arrow-left me-1"></i></a>
                @endif
            @endauth
        </div>
        <div class="row g-3">
            @forelse($featuredCampaigns as $campaign)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span
                                    class="badge badge-status {{ $campaign->status === \App\Enums\CampaignStatus::Published ? 'badge-success' : 'badge-info' }}">
                                    <i class="bi bi-circle-fill ms-1" style="font-size: 0.5rem;"></i>
                                    {{ $campaign->status->label() }}
                                </span>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 ms-1"></i> {{ $campaign->proposal_deadline?->format('Y-m-d') }}
                                </small>
                            </div>
                            <h3 class="h6 fw-bold mb-2">{{ $campaign->title }}</h3>
                            <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($campaign->description, 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center pt-2"
                                style="border-top: 1px solid var(--border-light);">
                                <div>
                                    <small class="text-muted">الميزانية</small>
                                    <div class="fw-bold" style="color: var(--primary);">
                                        {{ number_format((float) $campaign->budget, 0) }} ر.س</div>
                                </div>
                                @if($campaign->category)
                                    <span class="badge bg-light text-dark"
                                        style="font-size: 0.75rem;">{{ $campaign->category->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-megaphone d-block"></i>
                        <p>لا توجد حملات مميزة حالياً. كن أول من ينشر حملته!</p>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm mt-3">انشر حملتك الأولى</a>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ===== FEATURED AGENCIES ===== --}}
    <section class="mb-5 animate-in animate-delay-3">
        <div class="section-header">
            <h2><i class="bi bi-building ms-2"></i> وكالات نشطة</h2>
            <a href="{{ route('agencies.index') }}" class="btn btn-outline-primary btn-sm">الدليل الكامل <i
                    class="bi bi-arrow-left me-1"></i></a>
        </div>
        <div class="row g-3">
            @forelse($featuredAgencies as $agency)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="icon-box icon-box-primary"
                                    style="width: 44px; height: 44px; border-radius: 50%; font-size: 1.1rem;">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-0 d-flex align-items-center gap-2">
                                        {{ $agency->agency_name }}
                                        @if($agency->is_verified)
                                            <i class="bi bi-patch-check-fill" style="color: var(--primary); font-size: 1rem;"
                                                title="وكالة موثقة"></i>
                                        @endif
                                    </h3>
                                    <small class="text-muted">{{ $agency->city ?? 'غير محدد' }}</small>
                                </div>
                            </div>
                            <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($agency->about, 80) }}</p>
                            <div class="d-flex gap-3 pt-2" style="border-top: 1px solid var(--border-light);">
                                <div>
                                    <small class="text-muted d-block">الخبرة</small>
                                    <span class="fw-bold small">{{ $agency->years_experience ?? 0 }} سنوات</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block">الحد الأدنى</small>
                                    <span class="fw-bold small"
                                        style="color: var(--primary);">{{ number_format((float) $agency->minimum_budget, 0) }}
                                        ر.س</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-building d-block"></i>
                        <p>لا توجد وكالات معروضة الآن.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ===== WHY US SECTION ===== --}}
    <section class="mb-5 animate-in animate-delay-4">
        <div class="section-header">
            <h2>لماذا تختار Wassl؟</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <div class="icon-box icon-box-primary mb-3">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3 class="h6 fw-bold">شفافية كاملة</h3>
                    <p class="small text-muted mb-0">كل العروض والأسعار واضحة من البداية، لا رسوم خفية أو مفاجآت.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <div class="icon-box icon-box-accent mb-3">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <h3 class="h6 fw-bold">منافسة عادلة</h3>
                    <p class="small text-muted mb-0">الوكالات تتنافس على جودة الخدمة والسعر، مما يضمن لك أفضل نتيجة.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <div class="icon-box icon-box-purple mb-3">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h3 class="h6 fw-bold">نتائج مضمونة</h3>
                    <p class="small text-muted mb-0">نظام تقييم ومراجعات يضمن جودة الخدمة ويبني ثقة متبادلة بين الأطراف.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA SECTION ===== --}}
    <section class="animate-in animate-delay-4">
        <div class="hero-section text-center" style="padding: 2.5rem;">
            <h2 class="h3 fw-bold mb-3">جاهز لإطلاق حملتك الإعلانية؟</h2>
            <p style="color: rgba(255,255,255,0.7); max-width: 500px; margin: 0 auto 1.5rem;">
                سجّل الآن واحصل على عروض من أفضل وكالات التسويق الرقمي في المنطقة.
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('register') }}" class="btn btn-accent btn-lg">
                    <i class="bi bi-rocket-takeoff ms-1"></i> سجّل كشركة
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-building ms-1"></i> سجّل كوكالة
                </a>
            </div>
        </div>
    </section>
@endsection