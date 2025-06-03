@extends('layouts.app')
@section('page-title', 'Konselings Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('konselings.index') }}">Konselings</a></li>
    <li class="breadcrumb-item active">Konseling Details</li>
@endsection

@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('konselings.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
