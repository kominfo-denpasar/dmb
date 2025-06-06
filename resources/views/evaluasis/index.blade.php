@extends('layouts.app')
@section('page-title', 'Evaluasis')
@section('breadcrumb')
    <li class="breadcrumb-item active">Evaluasis</li>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('evaluasis.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('evaluasis.table')
        </div>
    </div>

@endsection
