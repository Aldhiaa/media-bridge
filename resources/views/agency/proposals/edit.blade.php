@extends('layouts.app')

@section('title', 'تعديل عرض')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4 mb-3">تعديل العرض</h1>
            <form method="POST" action="{{ route('agency.proposals.update', $proposal) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('agency.proposals._form')
                <button class="btn btn-primary mt-3">حفظ التعديلات</button>
            </form>
        </div>
    </div>
@endsection
