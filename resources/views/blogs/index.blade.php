@extends('layouts.app')
@section('page-title', 'Data Edukasi & Saran')
@section('breadcrumb')
    <li class="breadcrumb-item active">Data Edukasi & Saran</li>
@endsection
@section('content')

	<div class="content px-3">
		@include('flash::message')
		<div class="clearfix"></div>
		
		<div class="row">
			<div class="col-md-3">
					<a href="{{ route('blogs.create') }}" class="btn btn-primary btn-block mb-3">Tambah <span class="fas fa-plus-circle"></span></a>

					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Kategori</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body p-0">
							<ul class="nav nav-pills flex-column">
								<li class="nav-item active">
									<a href="#" class="nav-link">
										<i class="fas fa-filter"></i> [nama_kategori]
										<span class="badge bg-secondary float-right">-</span>
									</a>
								</li>
							</ul>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
				<div class="col-md-9">
					@include('blogs.table')
				</div>
				<!-- /.col -->
			</div>

				<div class="card">
						
				</div>
		</div>

@endsection
