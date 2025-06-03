@extends('layouts.app')
@section('page-title', 'Edit Konseling Masalahs')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('konseling-masalahs.index') }}">Konseling Masalahs</a></li>
    <li class="breadcrumb-item active">Edit Konseling Masalahs</li>
@endsection

@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($konselingMasalah, ['route' => ['konseling-masalahs.update', $konselingMasalah->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('konseling_masalahs.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('konseling-masalahs.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
