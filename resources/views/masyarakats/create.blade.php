@extends('layouts.app')
@section('page-title', 'Tambah Data Masyarakats')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('masyarakats.index') }}">Data Masyarakats</a></li>
    <li class="breadcrumb-item active">Tambah Data</li>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'masyarakats.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('masyarakats.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('masyarakats.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
