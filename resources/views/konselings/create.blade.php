@extends('layouts.app')
@section('page-title', 'Tambah Konselings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('konselings.index') }}">Konselings</a></li>
    <li class="breadcrumb-item active">Tambah Konselings</li>
@endsection

@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'konselings.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('konselings.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('konselings.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
