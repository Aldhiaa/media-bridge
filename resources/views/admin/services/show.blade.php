@extends('layouts.app')

@section('title', $service->name)

@section('content')
    <div class="card"><div class="card-body">
        <h1 class="h4">{{ $service->name }}</h1>
        <p class="text-muted">{{ $service->description }}</p>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
    </div></div>
@endsection
