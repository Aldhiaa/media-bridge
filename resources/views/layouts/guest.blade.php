@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card">
                <div class="card-body p-4 p-lg-5">
                    {{ $slot ?? '' }}
                    @yield('guest-content')
                </div>
            </div>
        </div>
    </div>
@endsection
