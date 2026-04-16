@extends('layouts.dashboard')

@section('title', 'إنشاء حملة - Wassl')

@section('content')
    <div class="page-header mb-4">
        <h1><i class="bi bi-plus-circle ms-2"></i> إنشاء حملة جديدة</h1>
        <p>أدخل تفاصيل حملتك الإعلانية لاستقبال عروض من الوكالات</p>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('company.campaigns.store') }}" enctype="multipart/form-data">
                @csrf
                @include('company.campaigns._form')
                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary"><i class="bi bi-check-lg ms-1"></i> نشر الحملة</button>
                    <a href="{{ route('company.campaigns.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection