@extends('layouts.app')
@section('page-title', 'Masalah Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('masalahs.index') }}">Data Masalahs</a></li>
    <li class="breadcrumb-item active">Masalah Details</li>
@endsection
@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('masalahs.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
