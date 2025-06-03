@extends('layouts.app')
@section('page-title', 'Tambah Data Blog')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Data Blogs</a></li>
    <li class="breadcrumb-item active">Tambah Data</li>
@endsection
@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'blogs.store', 'enctype'=>'multipart/form-data']) !!}

            <div class="card-body">

                <div class="row">
                    @include('blogs.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('blogs.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
