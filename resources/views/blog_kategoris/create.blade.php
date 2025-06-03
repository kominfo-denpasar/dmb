@extends('layouts.app')
@section('page-title', 'Tambah Blog Kategoris')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('blog-kategoris.index') }}">Data Blog Kategoris</a></li>
    <li class="breadcrumb-item active">Tambah Data</li>
@endsection
@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'blog-kategoris.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('blog_kategoris.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('blog-kategoris.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
