@extends('layouts.app')

@section('title', 'مراقبة العروض')

@section('content')
    <h1 class="h4 mb-3">مراقبة العروض</h1>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الحملة</th>
                    <th>الوكالة</th>
                    <th>السعر</th>
                    <th>الحالة</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($proposals as $proposal)
                    <tr>
                        <td>{{ $proposal->id }}</td>
                        <td>{{ $proposal->campaign->title }}</td>
                        <td>{{ $proposal->agency->name }}</td>
                        <td>{{ number_format((float)$proposal->proposed_price, 0) }}</td>
                        <td>{{ $proposal->status->value }}</td>
                        <td><a href="{{ route('admin.proposals.show', $proposal) }}" class="btn btn-sm btn-outline-primary">تفاصيل</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="text-center p-4 text-muted">لا توجد عروض.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $proposals->links() }}</div>
    </div>
@endsection
