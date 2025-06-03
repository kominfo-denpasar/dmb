@extends('layouts.app')
@section('page-title', 'Log Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('logs.index') }}">Data Logs</a></li>
    <li class="breadcrumb-item active">Log Details</li>
@endsection
@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('logs.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
