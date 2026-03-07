@extends('layouts.app')

@section('title', 'تعديل قطاع')

@section('content')
    <div class="card"><div class="card-body">
        <h1 class="h5 mb-3">تعديل قطاع</h1>
        <form method="POST" action="{{ route('admin.industries.update', $industry) }}">
            @csrf
            @method('PUT')
            <div class="mb-3"><label class="form-label">الاسم</label><input name="name" class="form-control" value="{{ old('name', $industry->name) }}" required></div>
            <div class="mb-3"><label class="form-label">الوصف</label><textarea name="description" class="form-control">{{ old('description', $industry->description) }}</textarea></div>
            <div class="form-check mb-3"><input type="checkbox" class="form-check-input" id="active" name="is_active" value="1" @checked($industry->is_active)><label class="form-check-label" for="active">نشط</label></div>
            <button class="btn btn-primary">حفظ</button>
        </form>
    </div></div>
@endsection
