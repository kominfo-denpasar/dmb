@extends('layouts.app')
@section('page-title', 'Tambah Keluhans')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('keluhans.index') }}">Keluhans</a></li>
    <li class="breadcrumb-item active">Tambah Keluhans</li>
@endsection

@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'keluhans.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('keluhans.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('keluhans.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
