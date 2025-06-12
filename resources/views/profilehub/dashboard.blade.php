@extends('profilehub::layouts.app')
@php

@endphp
@section('css') 
@endsection
@section('content')
<div class="card">
    <h5 class="card-header">{{ __('Dashboard') }}</h5>
    <div class="col-md-12 col-lg-12">
        <div class="card-header">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="card-body">


            {{ __('You are logged in!') }}
        </div>
    </div>
</div>
@endsection