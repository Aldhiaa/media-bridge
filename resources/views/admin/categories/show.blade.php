@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">{{ $category->name }}</h1>
            <p class="text-muted">{{ $category->description }}</p>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
        </div>
    </div>
@endsection
