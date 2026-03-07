@extends('layouts.app')

@section('title', 'تفاصيل حملة')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">{{ $campaign->title }}</h1>
        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <p>{{ $campaign->description }}</p>
                    <p><strong>الشركة:</strong> {{ $campaign->company->name }}</p>
                    <p><strong>العروض:</strong> {{ $campaign->proposals->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.campaigns.status', $campaign) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" name="status">
                                @foreach(config('marketplace.campaign_statuses') as $status)
                                    <option value="{{ $status }}" @selected($campaign->status->value === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="featured" name="is_featured" value="1" @checked($campaign->is_featured)>
                            <label for="featured" class="form-check-label">إبراز في الصفحة الرئيسية</label>
                        </div>
                        <button class="btn btn-primary btn-sm">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
