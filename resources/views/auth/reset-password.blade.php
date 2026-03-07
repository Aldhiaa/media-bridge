@extends('layouts.app')

@section('title', 'تعيين كلمة مرور جديدة')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body p-4">
                    <h1 class="h5 mb-3">تعيين كلمة مرور جديدة</h1>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ old('email', $request->email) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-primary">حفظ كلمة المرور</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
