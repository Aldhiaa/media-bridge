@extends('layouts.app')
@section('title', 'طريقة العمل - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-diagram-3 ms-2"></i> طريقة العمل</h1>
        <p>خطوات بسيطة وواضحة لإطلاق حملتك أو تقديم عروضك</p>
    </div>

    {{-- FOR COMPANIES --}}
    <div class="section-header">
        <h2><i class="bi bi-building ms-2"></i> للشركات</h2>
    </div>
    <div class="row g-3 mb-5">
        @php
            $companySteps = [
                ['icon' => 'bi-person-plus', 'color' => 'icon-box-primary', 'title' => 'أنشئ حساب شركة', 'desc' => 'سجّل حسابك كشركة واملأ بيانات ملفك التعريفي بما في ذلك مجال عملك ومعلومات التواصل.'],
                ['icon' => 'bi-pencil-square', 'color' => 'icon-box-accent', 'title' => 'أنشر حملتك الإعلانية', 'desc' => 'حدد تفاصيل حملتك: الوصف، الميزانية، القنوات المطلوبة، الفئة، والموعد النهائي لاستقبال العروض.'],
                ['icon' => 'bi-inbox', 'color' => 'icon-box-info', 'title' => 'استقبل العروض', 'desc' => 'وكالات التسويق المتخصصة ستقدم لك عروضها مع تفاصيل السعر والفكرة والخبرة السابقة.'],
                ['icon' => 'bi-check2-all', 'color' => 'icon-box-purple', 'title' => 'قارن واختر', 'desc' => 'قارن العروض المقدمة، تواصل مع الوكالات عبر الرسائل المباشرة، واقبل العرض الأنسب لك.'],
                ['icon' => 'bi-star', 'color' => 'icon-box-primary', 'title' => 'قيّم التجربة', 'desc' => 'بعد انتهاء الحملة، قيّم الوكالة لمساعدة الشركات الأخرى في اتخاذ قراراتها.'],
            ];
        @endphp
        @foreach($companySteps as $i => $step)
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex align-items-center gap-3 p-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-status badge-primary"
                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-weight: 800;">{{ $i + 1 }}</span>
                            <div class="icon-box {{ $step['color'] }}">
                                <i class="bi {{ $step['icon'] }}"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="h6 fw-bold mb-1">{{ $step['title'] }}</h3>
                            <p class="text-muted small mb-0">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- FOR AGENCIES --}}
    <div class="section-header">
        <h2><i class="bi bi-megaphone ms-2"></i> للوكالات</h2>
    </div>
    <div class="row g-3 mb-4">
        @php
            $agencySteps = [
                ['icon' => 'bi-person-badge', 'color' => 'icon-box-accent', 'title' => 'أنشئ حساب وكالة', 'desc' => 'سجّل كوكالة تسويق، أضف خدماتك وتخصصاتك وسنوات خبرتك وأعمالك السابقة.'],
                ['icon' => 'bi-search', 'color' => 'icon-box-info', 'title' => 'تصفح الحملات', 'desc' => 'ابحث وتصفح الحملات المتاحة حسب الفئة والميزانية والمجال، واحفظ الحملات المهمة في المفضلة.'],
                ['icon' => 'bi-send', 'color' => 'icon-box-primary', 'title' => 'قدّم عرضك', 'desc' => 'أرسل عرضك مع تفاصيل السعر والفكرة الإبداعية وخبرتك، وأرفق ملف العرض.'],
                ['icon' => 'bi-chat-dots', 'color' => 'icon-box-purple', 'title' => 'تواصل ونفّذ', 'desc' => 'تواصل مع الشركة مباشرة، ناقش التفاصيل، وابدأ التنفيذ بعد قبول عرضك.'],
            ];
        @endphp
        @foreach($agencySteps as $i => $step)
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex align-items-center gap-3 p-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-status badge-warning"
                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-weight: 800;">{{ $i + 1 }}</span>
                            <div class="icon-box {{ $step['color'] }}">
                                <i class="bi {{ $step['icon'] }}"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="h6 fw-bold mb-1">{{ $step['title'] }}</h3>
                            <p class="text-muted small mb-0">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection