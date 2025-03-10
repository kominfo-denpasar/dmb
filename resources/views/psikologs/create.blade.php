@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                        <h1>Tambah Data Psikolog</h1>
                </div>
                <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('psikologs.index') }}">Data Psikolog</a></li>
                            <li class="breadcrumb-item active">Tambah Data</li>
                        </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card card-primary">

            {!! Form::open(['route' => 'psikologs.store', 'enctype'=>'multipart/form-data']) !!}

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="callout callout-warning">
                        <h5>Isi field</h5>

                        <p>Perhatikan dan inputkan data informasi berdasarkan kolom yang diminta. Kolom yang memiliki tanda kurung bintang (*) wajib diisi agar form dapat di-submit.</p>
                        </div>
                    </div>
                    @include('psikologs.fields')
                </div>

            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('psikologs.index') }}" class="btn btn-default"> Batal </a>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
