@extends('layouts.app')
@section('title', 'المزايا - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-gem ms-2"></i> مزايا المنصة</h1>
        <p>كل ما تحتاجه لإطلاق حملات تسويقية ناجحة في مكان واحد</p>
    </div>

    <div class="row g-3">
        @php
            $features = [
                ['icon' => 'bi-shield-check', 'gradient' => 'stat-gradient-1', 'title' => 'شفافية كاملة', 'desc' => 'جميع العروض والأسعار واضحة ومتاحة للمقارنة. لا رسوم خفية أو مفاجآت غير متوقعة.'],
                ['icon' => 'bi-trophy-fill', 'gradient' => 'stat-gradient-3', 'title' => 'منافسة عادلة', 'desc' => 'الوكالات تتنافس على جودة الخدمة والسعر والإبداع، مما يضمن لك أفضل نتيجة ممكنة.'],
                ['icon' => 'bi-chat-square-dots-fill', 'gradient' => 'stat-gradient-2', 'title' => 'تواصل مباشر', 'desc' => 'نظام محادثات مدمج يتيح التواصل المباشر بين الشركات والوكالات حول كل حملة.'],
                ['icon' => 'bi-star-fill', 'gradient' => 'stat-gradient-4', 'title' => 'نظام تقييمات', 'desc' => 'تقييمات ومراجعات حقيقية تساعدك في اختيار الوكالة الأنسب بناءً على تجارب سابقة.'],
                ['icon' => 'bi-lock-fill', 'gradient' => 'stat-gradient-5', 'title' => 'أمان وخصوصية', 'desc' => 'جميع البيانات محمية ومشفرة. نضمن خصوصية معلوماتك التجارية وتفاصيل حملاتك.'],
                ['icon' => 'bi-phone-fill', 'gradient' => 'stat-gradient-6', 'title' => 'تصميم متجاوب', 'desc' => 'المنصة تعمل بسلاسة على جميع الأجهزة: الحاسوب، الجوال، والتابلت.'],
                ['icon' => 'bi-bell-fill', 'gradient' => 'stat-gradient-1', 'title' => 'إشعارات فورية', 'desc' => 'تنبيهات فورية عند استلام عروض جديدة أو تحديث حالة الحملة أو وصول رسائل.'],
                ['icon' => 'bi-bar-chart-fill', 'gradient' => 'stat-gradient-2', 'title' => 'لوحة تحكم شاملة', 'desc' => 'لوحة تحكم متكاملة لكل مستخدم تعرض الإحصائيات والتحديثات في مكان واحد.'],
                ['icon' => 'bi-patch-check-fill', 'gradient' => 'stat-gradient-4', 'title' => 'توثيق الوكالات', 'desc' => 'نظام توثيق خاص للوكالات المعتمدة يعزز الثقة ويميّز الأفضل في السوق.'],
            ];
        @endphp
        @foreach($features as $feature)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 p-4">
                    <div class="stat-card {{ $feature['gradient'] }} d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 56px; height: 56px; border-radius: var(--radius-md);">
                        <i class="bi {{ $feature['icon'] }}" style="font-size: 1.3rem; color: #fff;"></i>
                    </div>
                    <h3 class="h6 fw-bold">{{ $feature['title'] }}</h3>
                    <p class="small text-muted mb-0">{{ $feature['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection