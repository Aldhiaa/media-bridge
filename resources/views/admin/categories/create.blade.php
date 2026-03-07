@extends('layouts.dashboard')

@section('title', 'إضافة تصنيف')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h5 mb-3">إضافة تصنيف</h1>
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">الاسم</label>
                    <input name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="active" name="is_active" value="1" checked>
                    <label class="form-check-label" for="active">نشط</label>
                </div>
                <button class="btn btn-primary">حفظ</button>
            </form>
        </div>
    </div>
@endsection
