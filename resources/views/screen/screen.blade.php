@extends('screen.layouts.app')
@section('title')
@endsection

@section('content')
<my-screen :total="{{ json_encode($total) }}" :client="{{ json_encode($client) }}" :delivered="{{ json_encode($delivered) }}"></my-screen>
@endsection
