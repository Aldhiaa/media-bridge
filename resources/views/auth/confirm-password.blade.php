@extends('layouts.app')

@section('title', 'تأكيد كلمة المرور')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body p-4">
                    <h1 class="h5 mb-3">تأكيد كلمة المرور</h1>
                    <p class="small text-muted">لأمان حسابك، أدخل كلمة المرور قبل متابعة العملية.</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button class="btn btn-primary">تأكيد</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
