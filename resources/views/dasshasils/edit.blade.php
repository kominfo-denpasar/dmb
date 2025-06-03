@extends('layouts.app')
@section('page-title', 'Edit Dasshasils')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dasshasils.index') }}">Dasshasils</a></li>
    <li class="breadcrumb-item active">Edit Dasshasils</li>
@endsection

@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($dasshasil, ['route' => ['dasshasils.update', $dasshasil->id], 'method' => 'patch']) !!}

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
