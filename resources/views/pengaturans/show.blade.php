@extends('layouts.app')
@section('page-title', 'Pengaturan Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pengaturans.index') }}">Data Pengaturans</a></li>
    <li class="breadcrumb-item active">Pengaturan Details</li>
@endsection
@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('pengaturans.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
