@extends('layouts.app')
@section('page-title', 'Konseling Masalah Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('konseling-masalahs.index') }}">Konseling Masalahs</a></li>
    <li class="breadcrumb-item active">Konseling Masalah Details</li>
@endsection

@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('konseling_masalahs.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
