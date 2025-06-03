@extends('layouts.app')
@section('page-title', 'Profil')
@section('breadcrumb')
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content') 

<section class="content">
	<div class="container-fluid"> 
		<div class="row">
			<div class="col-lg-12">
				@if(session('message'))
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						{{session('message')}}
					</div>
				@endif
				@include('flash::message')
			</div>
			
			<div class="col-lg-12">
				<div class="card card-primary">
					<!-- form start -->
					@role('psikolog')
					{!! Form::model($psikolog, ['route' => ['backend.update-profil', $psikolog->id], 'method' => 'patch', 'enctype'=>'multipart/form-data']) !!}
					@else
					{!! Form::model($user, ['route' => ['backend.update-profil-admin', $user->id], 'method' => 'patch', 'enctype'=>'multipart/form-data']) !!}
					@endrole

					<div class="card-body">
						<div class="row">
							<div class="col-md-8 offset-md-2">
								<div class="callout callout-info">
									<h5>Isi field</h5>
									<p>Perhatikan dan inputkan data informasi berdasarkan kolom yang diminta. Kolom yang memiliki tanda kurung bintang (*) wajib diisi agar form dapat di-submit.</p>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							@role('psikolog')
								@include('backend.profil_psikolog')
							@else
								@include('backend.profil_admin')
							@endrole
						</div>
					</div>
					<!-- /.card-body -->

					<div class="card-footer">
						<div class="row">
							<div class="col-md-8 offset-md-2">
								<div class="form-group">
									<a href="{{ route('home') }}" class="btn btn-default"> Kembali </a>
									{!! Form::submit('Simpan', ['class' => 'btn btn-md btn-primary']) !!}
								</div>
							</div>
						</div>
						
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</section>
@endsection