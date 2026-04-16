@extends('layouts.dashboard')

@section('title', 'ملف الوكالة - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-megaphone ms-2"></i> ملف الوكالة</h1>
        <p>أكمل ملفك التعريفي لجذب أفضل فرص الحملات</p>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('agency.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h3 class="h6 fw-bold mb-3" style="color: var(--primary);"><i class="bi bi-info-circle ms-1"></i> المعلومات
                    الأساسية</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">اسم الوكالة <span class="text-danger">*</span></label>
                        <input class="form-control" name="agency_name"
                            value="{{ old('agency_name', $profile->agency_name) }}" required
                            placeholder="اسم الوكالة الرسمي">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">مسؤول التواصل <span class="text-danger">*</span></label>
                        <input class="form-control" name="contact_person"
                            value="{{ old('contact_person', $profile->contact_person) }}" required>
                    </div>
                </div>

                <h3 class="h6 fw-bold mb-3" style="color: var(--primary);"><i class="bi bi-telephone ms-1"></i> معلومات
                    التواصل</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $profile->email) }}"
                            required dir="ltr">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الهاتف <span class="text-danger">*</span></label>
                        <input class="form-control" name="phone" value="{{ old('phone', $profile->phone) }}" required
                            dir="ltr" placeholder="05xxxxxxxx">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الموقع الإلكتروني</label>
                        <input class="form-control" name="website" value="{{ old('website', $profile->website) }}" dir="ltr"
                            placeholder="https://example.com">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المدينة</label>
                        <input class="form-control" name="city" value="{{ old('city', $profile->city) }}"
                            placeholder="مثال: الرياض">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الدولة</label>
                        <input class="form-control" name="country" value="{{ old('country', $profile->country) }}"
                            placeholder="المملكة العربية السعودية">
                    </div>
                </div>

                <h3 class="h6 fw-bold mb-3" style="color: var(--primary);"><i class="bi bi-bar-chart ms-1"></i> معلومات
                    الوكالة</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">سنوات الخبرة</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="years_experience"
                                value="{{ old('years_experience', $profile->years_experience) }}" placeholder="5">
                            <span class="input-group-text">سنة</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الحد الأدنى للميزانية</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="minimum_budget"
                                value="{{ old('minimum_budget', $profile->minimum_budget) }}" placeholder="1000">
                            <span class="input-group-text">ر.س</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">حجم الفريق</label>
                        <input class="form-control" name="team_size" value="{{ old('team_size', $profile->team_size) }}"
                            placeholder="مثال: 5-10">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">أسلوب التسعير</label>
                        <input class="form-control" name="pricing_style"
                            value="{{ old('pricing_style', $profile->pricing_style) }}"
                            placeholder="مثال: بالمشروع أو بالساعة">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">شعار الوكالة</label>
                        <input type="file" class="form-control" name="logo">
                    </div>
                </div>

                <h3 class="h6 fw-bold mb-3" style="color: var(--primary);"><i class="bi bi-text-paragraph ms-1"></i> نبذة
                    تعريفية</h3>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <textarea rows="4" class="form-control" name="about"
                            placeholder="اكتب نبذة عن وكالتك وخبراتها وأعمالها السابقة...">{{ old('about', $profile->about) }}</textarea>
                    </div>
                </div>

                <h3 class="h6 fw-bold mb-3" style="color: var(--primary);"><i class="bi bi-tags ms-1"></i> التخصصات
                    والقطاعات</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">الخدمات الأساسية</label>
                        <small class="text-muted d-block mb-1">اضغط Ctrl للاختيار المتعدد</small>
                        <select class="form-select" name="service_ids[]" multiple size="6">
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" @selected(in_array($service->id, old('service_ids', $profile->services->pluck('id')->all()), true))>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">القطاعات المخدومة</label>
                        <small class="text-muted d-block mb-1">اضغط Ctrl للاختيار المتعدد</small>
                        <select class="form-select" name="industry_ids[]" multiple size="6">
                            @foreach($industries as $industry)
                                <option value="{{ $industry->id }}" @selected(in_array($industry->id, old('industry_ids', $profile->industries->pluck('id')->all()), true))>{{ $industry->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary"><i class="bi bi-check-lg ms-1"></i> حفظ التغييرات</button>
                    <a href="{{ route('agency.dashboard') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection