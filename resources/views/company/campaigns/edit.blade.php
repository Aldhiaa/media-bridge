@extends('layouts.dashboard')

@section('title', 'تعديل حملة')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4 mb-3">تعديل الحملة</h1>
            <form method="POST" action="{{ route('company.campaigns.update', $campaign) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('company.campaigns._form')
                <button class="btn btn-primary mt-3">حفظ التعديلات</button>
            </form>
        </div>
    </div>
@endsection
