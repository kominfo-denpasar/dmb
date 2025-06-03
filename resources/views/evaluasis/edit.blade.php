@extends('layouts.app')
@section('page-title', 'Edit Evaluasis')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('evaluasis.index') }}">Evaluasis</a></li>
    <li class="breadcrumb-item active">Edit Evaluasis</li>
@endsection

@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($evaluasi, ['route' => ['evaluasis.update', $evaluasi->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('evaluasis.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('evaluasis.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
