@extends('layouts.dashboard')

@section('title', 'تعديل خدمة')

@section('content')
    <div class="card"><div class="card-body">
        <h1 class="h5 mb-3">تعديل خدمة</h1>
        <form method="POST" action="{{ route('admin.services.update', $service) }}">
            @csrf
            @method('PUT')
            <div class="mb-3"><label class="form-label">الاسم</label><input name="name" class="form-control" value="{{ old('name', $service->name) }}" required></div>
            <div class="mb-3"><label class="form-label">الوصف</label><textarea name="description" class="form-control">{{ old('description', $service->description) }}</textarea></div>
            <div class="form-check mb-3"><input type="checkbox" class="form-check-input" id="active" name="is_active" value="1" @checked($service->is_active)><label class="form-check-label" for="active">نشط</label></div>
            <button class="btn btn-primary">حفظ</button>
        </form>
    </div></div>
@endsection
