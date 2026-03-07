@extends('layouts.app')

@section('title', 'تقييماتي')

@section('content')
    <h1 class="h4 mb-3">التقييمات المرسلة</h1>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                <tr>
                    <th>الحملة</th>
                    <th>الوكالة</th>
                    <th>التقييم</th>
                    <th>التعليق</th>
                    <th>الحالة</th>
                </tr>
                </thead>
                <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->campaign?->title }}</td>
                        <td>{{ $review->agency->agencyProfile->agency_name ?? $review->agency->name }}</td>
                        <td>{{ $review->rating }}/5</td>
                        <td>{{ $review->comment }}</td>
                        <td>{!! $review->is_approved ? '<span class="badge text-bg-success">Approved</span>' : '<span class="badge text-bg-warning">Pending</span>' !!}</td>
                    </tr>
                @empty
                    <tr><td colspan="5"><div class="text-center p-4 text-muted">لا توجد تقييمات.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $reviews->links() }}</div>
    </div>
@endsection
