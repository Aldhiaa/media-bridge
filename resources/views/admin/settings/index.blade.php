@extends('layouts.dashboard')

@section('title', 'إعدادات النظام - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-sliders ms-2"></i> إعدادات النظام</h1>
        <p>إدارة الإعدادات العامة للمنصة</p>
    </div>

    @php
        $groupLabels = [
            'general' => 'الإعدادات العامة',
            'platform' => 'إعدادات المنصة',
            'billing' => 'الفوترة والدفع',
            'notifications' => 'الإشعارات',
            'email' => 'البريد الإلكتروني',
            'seo' => 'تحسين محركات البحث',
        ];
        $keyLabels = [
            'site_name' => 'اسم الموقع',
            'site_description' => 'وصف الموقع',
            'site_email' => 'البريد الإلكتروني للموقع',
            'support_email' => 'بريد الدعم الفني',
            'platform_fee_percent' => 'نسبة عمولة المنصة (%)',
            'platform_fee' => 'رسوم المنصة',
            'currency' => 'العملة',
            'max_proposals_per_campaign' => 'الحد الأقصى للعروض لكل حملة',
            'proposal_deadline_days' => 'أيام الموعد النهائي للعروض',
            'auto_close_campaigns' => 'إغلاق الحملات تلقائياً',
            'min_budget' => 'الحد الأدنى للميزانية',
            'contact_phone' => 'رقم التواصل',
            'contact_address' => 'العنوان',
            'meta_title' => 'عنوان SEO',
            'meta_description' => 'وصف SEO',
        ];
        $groupIcons = [
            'general' => 'bi-gear',
            'platform' => 'bi-laptop',
            'billing' => 'bi-credit-card',
            'notifications' => 'bi-bell',
            'email' => 'bi-envelope',
            'seo' => 'bi-search',
        ];
    @endphp

    <div class="card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                @method('PUT')

                @foreach($settings as $group => $items)
                    <div class="mb-4">
                        <h3 class="h6 fw-bold mb-3" style="color: var(--primary);">
                            <i class="bi {{ $groupIcons[$group] ?? 'bi-gear' }} ms-1"></i>
                            {{ $groupLabels[$group] ?? $group }}
                        </h3>
                        <div class="row g-3">
                            @foreach($items as $item)
                                <div class="col-md-6">
                                    <label
                                        class="form-label small">{{ $keyLabels[$item->key] ?? str_replace('_', ' ', $item->key) }}</label>
                                    <input name="settings[{{ $item->key }}]" class="form-control"
                                        value="{{ old('settings.' . $item->key, $item->value) }}">
                                    <small class="text-muted" dir="ltr">{{ $item->key }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr style="border-color: var(--border-light);">
                    @endif
                @endforeach

                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-primary"><i class="bi bi-check-lg ms-1"></i> حفظ الإعدادات</button>
                </div>
            </form>
        </div>
    </div>
@endsection