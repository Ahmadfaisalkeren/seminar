@extends('admin.template.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h1 class="text-gradient">Welcome to your Dashboard, {{ auth()->user()->name }}</h1>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="card card-head">
                    <div class="card-body">
                        <h1 class="card-title text-white">Seminar Total</h1>
                        <p class="card-count text-white">{{ $seminar->count() }}</p>
                        <i class="nav-icon fas fa-archive fa-3x icon-right color-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-head">
                    <div class="card-body">
                        <h1 class="card-title text-white">Users Total</h1>
                        <p class="card-count text-white">{{ $users->count() }}</p>
                        <i class="nav-icon fas fa-address-card fa-3x icon-right color-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
