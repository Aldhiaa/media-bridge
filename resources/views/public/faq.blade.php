@extends('layouts.app')
@section('title', 'الأسئلة الشائعة - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-question-circle ms-2"></i> الأسئلة الشائعة</h1>
        <p>إجابات على أكثر الأسئلة شيوعاً حول المنصة</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion" id="faqAccordion">
                @php
                    $faqs = [
                        ['q' => 'ما هي Wassl؟', 'a' => 'Wassl منصة رقمية وسيطة تربط الشركات والعلامات التجارية بوكالات التسويق الرقمي. تتيح للشركات نشر حملاتها الإعلانية واستقبال عروض تنافسية من الوكالات المتخصصة.'],
                        ['q' => 'هل استخدام المنصة مجاني؟', 'a' => 'نعم، التسجيل والاستخدام الأساسي مجاني تماماً لكل من الشركات والوكالات. يمكنك نشر حملاتك وتقديم عروضك دون أي رسوم.'],
                        ['q' => 'كيف أسجّل كشركة؟', 'a' => 'اضغط على "إنشاء حساب"، اختر نوع الحساب "شركة"، أكمل بياناتك الأساسية ثم أكمل ملفك التعريفي بتفاصيل شركتك ومجال عملك.'],
                        ['q' => 'كيف أسجّل كوكالة تسويق؟', 'a' => 'اضغط على "إنشاء حساب"، اختر نوع الحساب "وكالة"، أكمل بياناتك وأضف خدماتك وتخصصاتك وسنوات خبرتك وأعمالك السابقة.'],
                        ['q' => 'كيف أنشر حملة إعلانية؟', 'a' => 'بعد تسجيل الدخول كشركة، اذهب إلى لوحة التحكم واضغط "حملة جديدة". أدخل تفاصيل الحملة: العنوان، الوصف، الميزانية، القنوات المطلوبة، والموعد النهائي.'],
                        ['q' => 'كيف أقدم عرضاً على حملة؟', 'a' => 'بعد تسجيل الدخول كوكالة، تصفح الحملات المتاحة، اضغط على الحملة التي تريد، ثم اضغط "تقديم عرض" وأدخل تفاصيل عرضك من سعر وفكرة وخبرة.'],
                        ['q' => 'هل يمكنني التواصل مع الطرف الآخر قبل القبول؟', 'a' => 'نعم، توفر المنصة نظام محادثات مباشر يتيح للشركة والوكالة التواصل وتبادل التفاصيل حول الحملة قبل وبعد قبول العرض.'],
                        ['q' => 'ما معنى "وكالة موثقة"؟', 'a' => 'الوكالة الموثقة هي وكالة تم التحقق من بياناتها وخبرتها من قبل إدارة المنصة. التوثيق يعزز ثقة الشركات ويميّز الوكالة عن المنافسين.'],
                    ];
                @endphp
                @foreach($faqs as $i => $faq)
                    <div class="accordion-item border-0 mb-2"
                        style="border-radius: var(--radius-md) !important; overflow: hidden; box-shadow: var(--shadow-sm);">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }} fw-bold" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}" style="font-size: 0.95rem;">
                                {{ $faq['q'] }}
                            </button>
                        </h2>
                        <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted" style="line-height: 1.9;">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card p-4 mt-4 text-center">
                <p class="mb-2 fw-bold">لم تجد إجابة لسؤالك؟</p>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-sm"><i class="bi bi-envelope ms-1"></i> تواصل
                    معنا</a>
            </div>
        </div>
    </div>
@endsection