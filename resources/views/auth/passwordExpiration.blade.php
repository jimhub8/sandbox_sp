@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Pasword') }}</div>
                @if (session('error'))
                <div class="alert alert-danger text-center">
                    <p>{{ session('error') }}</p>
                </div>

                @elseif (session('success'))
                <div class="alert alert-success text-center">
                    <p>{{ session('success') }}</p>
                </div>
                @elseif (session('info'))
                <div class="alert alert-info text-center">
                    <p>{{ session('info') }}</p>
                </div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('passwordExpiration') }}">
                        @csrf

                        {{--  <input type="hidden" name="token" value="{{ $token }}"> --}}


                        <div class="form-group row">
                            <label for="current-password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password"
                                    class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}"
                                    name="current-password" required>

                                @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="new-password" required>

                                @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
