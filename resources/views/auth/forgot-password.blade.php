@extends('layouts.app')

@section('title', 'استعادة كلمة المرور')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body p-4">
                    <h1 class="h5 mb-3">استعادة كلمة المرور</h1>
                    <p class="text-muted small">أدخل بريدك الإلكتروني وسيتم إرسال رابط إعادة التعيين.</p>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <button class="btn btn-primary">إرسال الرابط</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
