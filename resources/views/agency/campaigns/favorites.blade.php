@extends('layouts.dashboard')

@section('title', 'الحملات المحفوظة')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">الحملات المحفوظة</h1>
        <a href="{{ route('agency.campaigns.index') }}" class="btn btn-outline-secondary btn-sm">عودة للحملات</a>
    </div>

    <div class="row g-3">
        @forelse($campaigns as $campaign)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h6">{{ $campaign->title }}</h2>
                        <p class="small text-muted">{{ \Illuminate\Support\Str::limit($campaign->description, 90) }}</p>
                        <div class="small mb-2">الميزانية: {{ number_format((float)$campaign->budget, 0) }} USD</div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('agency.campaigns.show', $campaign) }}" class="btn btn-sm btn-outline-primary">تفاصيل</a>
                            <form method="POST" action="{{ route('agency.campaigns.unfavorite', $campaign) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">إزالة</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-light border">لا توجد حملات محفوظة.</div></div>
        @endforelse
    </div>

    <div class="mt-3">{{ $campaigns->links() }}</div>
@endsection
