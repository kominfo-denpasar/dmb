@extends('layouts.app')
@section('page-title', 'Blog Kategori Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('blog-kategoris.index') }}">Blog Kategoris</a></li>
    <li class="breadcrumb-item active">Blog Kategori Details</li>
@endsection
@section('content')

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('blog_kategoris.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
