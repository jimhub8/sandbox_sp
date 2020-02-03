@extends('layouts.app')
@section('title') Courier
@endsection

@section('content')
<div id="app_reload">
    <my-header :user="{{ json_encode($auth_user) }}"></my-header>
    <transition name="fade">
        <router-view :user="{{ json_encode($auth_user) }}"></router-view>
    </transition>
</div>
@endsection
