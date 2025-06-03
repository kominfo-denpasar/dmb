@extends('layouts.app')
@section('page-title', 'Evaluasi Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('evaluasis.index') }}">Evaluasi Details</a></li>
    <li class="breadcrumb-item active">Evaluasi Details</li>
@endsection

@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('evaluasis.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
