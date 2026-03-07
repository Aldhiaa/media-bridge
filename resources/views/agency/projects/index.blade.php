@extends('layouts.app')

@section('title', 'المشاريع الفائزة')

@section('content')
    <h1 class="h4 mb-3">المشاريع التي فزت بها</h1>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                <tr>
                    <th>الحملة</th>
                    <th>الشركة</th>
                    <th>قيمة المشروع</th>
                    <th>حالة الحملة</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($projects as $proposal)
                    <tr>
                        <td>{{ $proposal->campaign->title }}</td>
                        <td>{{ $proposal->campaign->company->companyProfile->company_name ?? $proposal->campaign->company->name }}</td>
                        <td>{{ number_format((float)$proposal->proposed_price, 0) }} USD</td>
                        <td><span class="badge text-bg-info">{{ $proposal->campaign->status->label() }}</span></td>
                        <td><a href="{{ route('agency.projects.show', $proposal) }}" class="btn btn-sm btn-outline-primary">تفاصيل</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5"><div class="text-center p-4 text-muted">لا توجد مشاريع فائزة حالياً.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $projects->links() }}</div>
    </div>
@endsection
