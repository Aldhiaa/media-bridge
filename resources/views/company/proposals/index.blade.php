@extends('layouts.dashboard')

@section('title', 'مقارنة العروض')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">مقارنة عروض الحملة: {{ $campaign->title }}</h1>
        <a href="{{ route('company.campaigns.show', $campaign) }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">ترتيب حسب</label>
                    <select name="sort" class="form-select">
                        <option value="date" @selected(($sort ?? 'date') === 'date')>التاريخ</option>
                        <option value="price" @selected(($sort ?? '') === 'price')>السعر</option>
                        <option value="experience" @selected(($sort ?? '') === 'experience')>الخبرة</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الاتجاه</label>
                    <select name="direction" class="form-select">
                        <option value="desc" @selected(($direction ?? 'desc') === 'desc')>تنازلي</option>
                        <option value="asc" @selected(($direction ?? '') === 'asc')>تصاعدي</option>
                    </select>
                </div>
                <div class="col-md-2 align-self-end">
                    <button class="btn btn-primary w-100">تطبيق</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                <tr>
                    <th>الوكالة</th>
                    <th>السعر</th>
                    <th>الفكرة</th>
                    <th>المدة</th>
                    <th>الخبرة</th>
                    <th>الحالة</th>
                    <th>إجراء</th>
                </tr>
                </thead>
                <tbody>
                @forelse($proposals as $proposal)
                    <tr>
                        <td>{{ $proposal->agency->agencyProfile->agency_name ?? $proposal->agency->name }}</td>
                        <td>{{ number_format((float)$proposal->proposed_price, 0) }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($proposal->strategy_summary, 90) }}</td>
                        <td>{{ $proposal->execution_timeline }}</td>
                        <td>{{ $proposal->agency->agencyProfile->years_experience ?? 0 }} سنوات</td>
                        <td><span class="badge text-bg-secondary">{{ $proposal->status->label() }}</span></td>
                        <td class="text-nowrap">
                            <form method="POST" action="{{ route('company.proposals.shortlist', $proposal) }}" class="d-inline">@csrf<button class="btn btn-sm btn-outline-info">Shortlist</button></form>
                            <form method="POST" action="{{ route('company.proposals.accept', $proposal) }}" class="d-inline">@csrf<button class="btn btn-sm btn-outline-success">Accept</button></form>
                            <form method="POST" action="{{ route('company.proposals.reject', $proposal) }}" class="d-inline">@csrf<button class="btn btn-sm btn-outline-danger">Reject</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="text-center p-4 text-muted">لا توجد عروض.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
