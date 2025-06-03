@extends('layouts.app')
@section('page-title', 'Keluhan Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('keluhans.index') }}">Keluhans</a></li>
    <li class="breadcrumb-item active">Keluhan Details</li>
@endsection

@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('keluhans.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
