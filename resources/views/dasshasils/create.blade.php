@extends('layouts.app')
@section('page-title', 'Create Dasshasils')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dasshasils.index') }}">Dasshasils</a></li>
    <li class="breadcrumb-item active">Create Dasshasils</li>
@endsection

@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'dasshasils.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('dasshasils.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('dasshasils.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
