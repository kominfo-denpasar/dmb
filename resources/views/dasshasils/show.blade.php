@extends('layouts.app')
@section('page-title', 'Dasshasil Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dasshasils.index') }}">Dasshasils</a></li>
    <li class="breadcrumb-item active">Dasshasil Details</li>
@endsection

@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('dasshasils.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
