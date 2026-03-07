@extends('layouts.app')

@section('title', 'تفاصيل عرض')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">عرض #{{ $proposal->id }}</h1>
        <a href="{{ route('admin.proposals.index') }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <p><strong>الحملة:</strong> {{ $proposal->campaign->title }}</p>
                    <p><strong>الوكالة:</strong> {{ $proposal->agency->name }}</p>
                    <p>{{ $proposal->strategy_summary }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.proposals.status', $proposal) }}">
                        @csrf
                        @method('PUT')
                        <label class="form-label">حالة العرض</label>
                        <select name="status" class="form-select mb-2">
                            @foreach(config('marketplace.proposal_statuses') as $status)
                                <option value="{{ $status }}" @selected($proposal->status->value === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary btn-sm">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
