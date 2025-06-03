@extends('layouts.app')
@section('page-title', 'Edit Data Logs')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('psikologs.index') }}">Data Logs</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection
@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($log, ['route' => ['logs.update', $log->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('logs.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('logs.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
