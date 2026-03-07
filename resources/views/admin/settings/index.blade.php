@extends('layouts.app')

@section('title', 'إعدادات النظام')

@section('content')
    <h1 class="h4 mb-3">إعدادات النظام</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    @foreach($settings as $group => $items)
                        <div class="col-12">
                            <h2 class="h6 border-bottom pb-2">{{ ucfirst($group) }}</h2>
                        </div>
                        @foreach($items as $item)
                            <div class="col-md-6">
                                <label class="form-label">{{ $item->key }}</label>
                                <input name="settings[{{ $item->key }}]" class="form-control" value="{{ old('settings.'.$item->key, $item->value) }}">
                            </div>
                        @endforeach
                    @endforeach
                </div>

                <button class="btn btn-primary mt-3">حفظ الإعدادات</button>
            </form>
        </div>
    </div>
@endsection
