@extends('layouts.app')

@section('title', 'تأكيد البريد الإلكتروني')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card">
                <div class="card-body p-4">
                    <h1 class="h5 mb-3">تأكيد البريد الإلكتروني</h1>
                    <p>تم إرسال رابط التفعيل إلى بريدك الإلكتروني. يرجى التحقق من البريد قبل المتابعة.</p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success">
                            تم إرسال رابط جديد.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-primary">إعادة إرسال الرابط</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
