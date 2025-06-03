@extends('layouts.app')
@section('page-title', 'Catatan Log')
@section('breadcrumb')
    <li class="breadcrumb-item active">Catatan Log</li>
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
