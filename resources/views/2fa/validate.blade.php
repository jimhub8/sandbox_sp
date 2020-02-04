@extends('layouts.app')

@section('content')
<div class="limiter">
    <div class="container-login100" style="background-image: url('/storage/bg.webp');">
        {{--  <div class="container-login100" style="background-image: url('https://colorlib.com/etc/lf/Login_v16/images/bg-01.jpg');">  --}}
        <div class="wrap-login100 p-t-30 p-b-50">
            <span class="login100-form-title p-b-41">
                One Time Password
            </span>
            <form class="login100-form validate-form p-b-33 p-t-5" action="/2fa/validate" method="POST">
                {{--  <form class="form-horizontal" role="form" method="POST" action="/2fa/validate">  --}}
                @csrf
                <div class="wrap-input100 validate-input" data-validate="Enter username">
                    {{--  <input type="number" class="form-control" name="otp">  --}}
                    <input class="input100" type="number" name="otp" placeholder="Enter the code" autofocus style="border-bottom: 1px solid #0000005c;margin-left: 30px;">
                    @if ($errors->has('otp'))
                    <hr>
                    <span class="help-block">
                        <div class="text-danger text-center">{{ $errors->first('otp') }}</div>
                    </span>
                    @endif
                    {{--  <span class="focus-input100" data-placeholder="&#xe82a;"></span>  --}}
                </div>
                <div class="container-login100-form-btn m-t-32">
                    <button type="submit" class="btn btn-primary">
                        Verify
                    </button>
                    <a href="/login">User another way</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="dropDownSelect1"></div>
@endsection

