@extends('layouts.app')
@section('page-title', 'Edit Blog Kategoris')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('blog-kategoris.index') }}">Blog Kategori</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection
@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($blogKategori, ['route' => ['blog-kategoris.update', $blogKategori->id], 'method' => 'patch']) !!}

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
