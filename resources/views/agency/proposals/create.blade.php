@extends('layouts.dashboard')

@section('title', 'تقديم عرض')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4 mb-2">تقديم عرض على حملة</h1>
            <p class="text-muted">{{ $campaign->title }}</p>

            @if($existingProposal)
                <div class="alert alert-warning">لديك عرض سابق لهذه الحملة. سيتم تعديل العرض الحالي كنسخة محدثة.</div>
            @endif

            <form method="POST" action="{{ route('agency.proposals.store', $campaign) }}" enctype="multipart/form-data">
                @csrf
                @php($proposal = $existingProposal)
                @include('agency.proposals._form')
                <button class="btn btn-primary mt-3">إرسال العرض</button>
            </form>
        </div>
    </div>
@endsection
