@extends('layouts.dashboard')

@section('title', $industry->name)

@section('content')
    <div class="card"><div class="card-body">
        <h1 class="h4">{{ $industry->name }}</h1>
        <p class="text-muted">{{ $industry->description }}</p>
        <a href="{{ route('admin.industries.index') }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
    </div></div>
@endsection
