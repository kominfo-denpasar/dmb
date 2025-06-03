@extends('layouts.app')
@section('page-title', 'Data Masyarakat')
@section('breadcrumb')
    <li class="breadcrumb-item active"> Data Masyarakat</li>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <a class="btn btn-primary float-right"
                       href="{{ route('masyarakats.create') }}">
                        Add New
                    </a> --}} <!-- Hide button add new to create new masyarakats -->
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('masyarakats.table')
        </div>
    </div>

@endsection
