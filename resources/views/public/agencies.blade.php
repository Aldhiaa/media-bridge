@extends('layouts.app')

@section('title', 'دليل الوكالات')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form class="row g-2">
                <div class="col-md-3">
                    <input class="form-control" name="q" placeholder="بحث" value="{{ $filters['q'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="service_id">
                        <option value="">كل الخدمات</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" @selected(($filters['service_id'] ?? null) == $service->id)>{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="industry_id">
                        <option value="">كل القطاعات</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry->id }}" @selected(($filters['industry_id'] ?? null) == $industry->id)>{{ $industry->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input class="form-control" name="city" placeholder="المدينة" value="{{ $filters['city'] ?? '' }}">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100">فلتر</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        @forelse($agencies as $agency)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h6 d-flex align-items-center gap-2">
                            <span>{{ $agency->agency_name }}</span>
                            @if($agency->is_verified)
                                <span class="badge text-bg-primary">موثقة</span>
                            @endif
                        </h2>
                        <p class="small text-muted">{{ \Illuminate\Support\Str::limit($agency->about, 110) }}</p>
                        <div class="small">الخبرة: {{ $agency->years_experience ?? 0 }} سنوات</div>
                        <div class="small mb-2">الحد الأدنى: {{ number_format((float)$agency->minimum_budget, 0) }} USD</div>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($agency->services->take(4) as $service)
                                <span class="badge text-bg-light border">{{ $service->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border">لا توجد نتائج مطابقة.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $agencies->links() }}</div>
@endsection
