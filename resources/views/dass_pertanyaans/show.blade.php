@extends('layouts.app')
@section('page-title', 'Dass Pertanyaans Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dassPertanyaans.index') }}">Dass Pertanyaans</a></li>
    <li class="breadcrumb-item active">Dass Pertanyaan Details</li>
@endsection

@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('dass_pertanyaans.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
