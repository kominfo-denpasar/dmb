@extends('layouts.app')
@section('page-title', 'Edit Data Psikolog')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('psikologs.index') }}">Data Psikolog</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection
@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($psikolog, ['route' => ['psikologs.update', $psikolog->id], 'method' => 'patch', 'enctype'=>'multipart/form-data']) !!}

            <div class="card-body">
                <div class="row">
                    @include('psikologs.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('psikologs.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
