@extends('layouts.app')
@section('page-title', 'Catatan Log')
@section('breadcrumb')
    <li class="breadcrumb-item active">Catatan Log</li>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('logs.table')
        </div>
    </div>

@endsection
