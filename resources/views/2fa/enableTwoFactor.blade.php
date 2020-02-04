@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card" style="margin: auto; width: 50%">
        <div class="card-body">
          <h5 class="card-title">2FA Secret Key</h5>
          <h6 class="card-subtitle mb-2 text-muted">Open up your
            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">2FA mobile app</a> and scan the following QR barcode:</h6>
          <div class="card-text">
            <img alt="Image of QR barcode" src="{{ $image }}" />

            <br />
            If your <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">2FA mobile app</a>  does not support QR barcodes,
            enter in the following number: <code>{{ $secret }}</code>
            <br /><br />
          </div>
          <a href="/courier" class="card-link btn btn-primary">Dashboard</a>

          <form action="/logoutOther" method="get" style="float: right;">
              @csrf
              <button type="submit" class="card-link btn btn-primary">Logout other devices</button>
          </form>
        </div>
      </div>
</div>
@endsection
