@extends('layouts.dashboard')

@section('title', 'تفاصيل المشروع')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">تفاصيل المشروع</h1>
        <a href="{{ route('agency.projects.index') }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="h5">{{ $proposal->campaign->title }}</h2>
                    <p>{{ $proposal->campaign->description }}</p>
                    <p><strong>المخرجات المطلوبة:</strong> {{ $proposal->campaign->required_deliverables }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>حالة الحملة:</strong> {{ $proposal->campaign->status->label() }}</li>
                        <li class="mb-2"><strong>الميزانية المتفق عليها:</strong> {{ number_format((float)$proposal->proposed_price, 0) }} USD</li>
                        <li><strong>المدة:</strong> {{ $proposal->execution_timeline }}</li>
                    </ul>
                </div>
            </div>
            @if($conversation)
                <a href="{{ route('conversations.show', $conversation) }}" class="btn btn-primary w-100">إرسال تحديث/تسليم عبر المحادثة</a>
            @endif
        </div>
    </div>
@endsection
