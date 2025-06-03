@extends('layouts.app')
@section('page-title', 'Blog Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Data Blogs</a></li>
    <li class="breadcrumb-item active">Blog Details</li>
@endsection
@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('blogs.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
