@extends('layouts.dashboard')

@section('title', 'ملف الشركة - Media Bridge')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-building ms-2"></i> ملف الشركة</h1>
        <p>أكمل ملفك التعريفي ليظهر بشكل احترافي للوكالات</p>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('company.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h3 class="h6 fw-bold mb-3" style="color: var(--primary);"><i class="bi bi-info-circle ms-1"></i> المعلومات
                    الأساسية</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">اسم الشركة <span class="text-danger">*</span></label>
                        <input class="form-control" name="company_name"
                            value="{{ old('company_name', $profile->company_name) }}" required
                            placeholder="اسم الشركة الرسمي">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">العلامة التجارية</label>
                        <input class="form-control" name="brand_name" value="{{ old('brand_name', $profile->brand_name) }}"
                            placeholder="اسم العلامة التجارية (إن وجد)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">مسؤول التواصل <span class="text-danger">*</span></label>
                        <input class="form-control" name="contact_person"
                            value="{{ old('contact_person', $profile->contact_person) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">القطاع</label>
                        <select class="form-select" name="industry_id">
                            <option value="">اختر القطاع</option>
                            @foreach($industries as $industry)
                                <option value="{{ $industry->id }}" @selected(old('industry_id', $profile->industry_id) == $industry->id)>{{ $industry->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h3 class="h6 fw-bold mb-3" style="color: var(--primary);"><i class="bi bi-telephone ms-1"></i> معلومات
                    التواصل</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $profile->email) }}"
                            required dir="ltr">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الهاتف <span class="text-danger">*</span></label>
                        <input class="form-control" name="phone" value="{{ old('phone', $profile->phone) }}" required
                            dir="ltr" placeholder="05xxxxxxxx">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الموقع الإلكتروني</label>
                        <input class="form-control" name="website" value="{{ old('website', $profile->website) }}" dir="ltr"
                            placeholder="https://example.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">المدينة</label>
                        <input class="form-control" name="city" value="{{ old('city', $profile->city) }}"
                            placeholder="مثال: الرياض">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الدولة</label>
                        <input class="form-control" name="country" value="{{ old('country', $profile->country) }}"
                            placeholder="المملكة العربية السعودية">
                    </div>
                </div>

                <h3 class="h6 fw-bold mb-3" style="color: var(--primary);"><i class="bi bi-text-paragraph ms-1"></i> نبذة
                    ومرفقات</h3>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label">نبذة عن الشركة</label>
                        <textarea class="form-control" rows="4" name="description"
                            placeholder="اكتب نبذة مختصرة عن شركتك وأعمالها...">{{ old('description', $profile->description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">شعار الشركة</label>
                        <input type="file" class="form-control" name="logo">
                        <small class="text-muted">صيغ مقبولة: PNG, JPG, SVG</small>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary"><i class="bi bi-check-lg ms-1"></i> حفظ التغييرات</button>
                    <a href="{{ route('company.dashboard') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection