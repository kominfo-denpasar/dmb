@extends('layouts.app')
@section('page-title', 'Masyarakat Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('masyarakats.index') }}">Data Masyarakats</a></li>
    <li class="breadcrumb-item active">Masyarakat Details</li>
@endsection
@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('masyarakats.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
