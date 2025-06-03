@extends('layouts.app')
@section('page-title', 'Kategori')
@section('breadcrumb')
    <li class="breadcrumb-item active">Kategori</li>
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
                       href="{{ route('blog-kategoris.create') }}">
                        Tambah Baru
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('blog_kategoris.table')
        </div>
    </div>

@endsection
