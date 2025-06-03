@extends('layouts.app')
@section('page-title', 'Konfigurasi & Narasi')
@section('breadcrumb')
    <li class="breadcrumb-item active">Konfigurasi & Narasi</li>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <!-- <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('pengaturans.create') }}">
                        Add New
                    </a>
                </div> -->
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('pengaturans.table')
        </div>
    </div>

@endsection
