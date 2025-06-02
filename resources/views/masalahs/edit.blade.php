@extends('layouts.app')
@section('page-title', 'Edit Data Masalahs')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('masalahs.index') }}">Data Masalahs</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection
@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($masalah, ['route' => ['masalahs.update', $masalah->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('masalahs.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('masalahs.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
