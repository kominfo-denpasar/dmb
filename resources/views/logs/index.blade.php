@extends('layouts.app')
@section('page-title', 'Logs')
@section('breadcrumb')
    <li class="breadcrumb-item active">Logs</li>
@endsection
@section('content')

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('logs.table')
        </div>
    </div>

@endsection
