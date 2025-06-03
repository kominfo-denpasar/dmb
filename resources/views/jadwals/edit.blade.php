@extends('layouts.app')
@section('page-title', 'Edit Data Jadwal')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('jadwals.index') }}">Data Jadwal Psikolog</a></li>
    <li class="breadcrumb-item active">Edit Data Jadwal</li>
@endsection

@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($jadwal, ['route' => ['jadwals.update', $jadwal->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('jadwals.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('jadwals.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
