@extends('layouts.app')
@section('page-title', 'Edit Data Pengaturan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pengaturans.index') }}">Data Pengaturans</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection
@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($pengaturan, ['route' => ['pengaturans.update', $pengaturan->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('pengaturans.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('pengaturans.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
