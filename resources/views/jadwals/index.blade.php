@extends('layouts.app')
@section('page-title', 'Data Jadwal Psikolog')
@section('breadcrumb')
    <li class="breadcrumb-item active">Data Jadwal Psikolog</li>
@endsection

@section('content')

		<div class="content px-3">

				@include('flash::message')

				<div class="clearfix"></div>

				<div class="row">
				<div class="col-md-3">
					<a href="{{ route('jadwals.create') }}" class="btn btn-primary btn-block mb-3">Tambah</a>

					<div class="card">
						<!-- <div class="card-header">
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
										<i class="fas fa-filter"></i> Aktif
										<span class="badge bg-success float-right">-</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<i class="fas fa-filter"></i> Tidak Aktif
										<span class="badge bg-danger float-right">-</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<i class="far fa-trash-alt"></i> Arsip
									</a>
								</li>
							</ul>
						</div> -->
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
                     
				</div>
				<!-- /.col -->
				<div class="col-md-9">
					@include('jadwals.table')
				</div>
				<!-- /.col -->
			</div>

				<div class="card">
						
				</div>
		</div>

@endsection

