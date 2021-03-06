@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-card>
                <x-card-header>
                    @lang('interface.Register')
                </x-card-header>

                <x-card-body>
                    <x-form.form action="{{ route('register') }}">
                        @csrf

                        <x-form.form-item class="row">
                            <x-form.label for="name">
                                @lang('interface.Name')
                            </x-form.label>

                            <div class="col-md-6">
                                <x-name-form-field />
                            </div>
                        </x-form.form-item>

                        @include('layouts.auth')

                        <x-form.form-item class="row">
                            <x-form.label for="password-confirm">@lang('interface.Confirmation')</x-form.label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </x-form.form-item>
                        <x-form.form-item class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-primary" type="submit">
                                    @lang('interface.RegisterBtn')
                                </button>
                            </div>
                        </x-form.form-item>
                    </x-form.form>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
@endsection
