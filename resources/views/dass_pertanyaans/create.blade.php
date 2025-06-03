@extends('layouts.app')
@section('page-title', 'Tambah Dass Pertanyaans')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dasspertanyaans.index') }}">Dass Pertanyaans</a></li>
    <li class="breadcrumb-item active">Tambah Data</li>
@endsection

@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'dassPertanyaans.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('dass_pertanyaans.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('dassPertanyaans.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
