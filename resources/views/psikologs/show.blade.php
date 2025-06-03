@extends('layouts.app')
@section('page-title', 'Psikolog Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('psikologs.index') }}">Data Psikolog</a></li>
    <li class="breadcrumb-item active">Psikolog Details</li>
@endsection
@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('psikologs.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
