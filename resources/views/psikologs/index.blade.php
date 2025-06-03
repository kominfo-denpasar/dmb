@extends('layouts.app')
@section('page-title', 'Data Psikolog')
@section('breadcrumb')
    <li class="breadcrumb-item active">Psikolog</li>
@endsection
@section('content')
		<div class="content px-3">

				@include('flash::message')

				<div class="clearfix"></div>

				<div class="row">
				<div class="col-md-3">
					<a href="{{ route('psikologs.create') }}" class="btn btn-primary btn-block mb-3">Tambah <span class="fas fa-plus-circle"></span></a>

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
							@php
								$currentStatus = request('status');
							@endphp
							<ul class="nav nav-pills flex-column">
								<li class="nav-item {{ $currentStatus === '1' ? 'active' : '' }}">
									<a href="{{ $currentStatus === '1' ? route('psikologs.index') : route('psikologs.index', ['status' => '1']) }}" class="nav-link">
										<i class="fas fa-filter"></i> Aktif
       		 							<span class="badge bg-success float-right">{{ \App\Models\Psikolog::where('status', '1')->count() }}</span>
									</a>
								</li>
								<li class="nav-item {{ request('status') == '0' ? 'active' : '' }}">
									<a href="{{ $currentStatus === '0' ? route('psikologs.index') : route('psikologs.index', ['status' => '0']) }}" class="nav-link">
										<i class="fas fa-filter"></i> Tidak Aktif
										<span class="badge bg-danger float-right">{{ \App\Models\Psikolog::where('status', '0')->count() }}</span>
									</a>
								</li>
								<li class="nav-item {{ request('status') == 'arsip' ? 'active' : '' }}">
									<a href="{{ $currentStatus === 'arsip' ? route('psikologs.index') : route('psikologs.index', ['status' => 'arsip']) }}" class="nav-link">
										<i class="far fa-trash-alt"></i> Arsip
										<span class="badge bg-secondary float-right">{{ \App\Models\Psikolog::where('status', '2')->count() }}</span>
									</a>
								</li>
							</ul>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
					<div class="card">
						<div class="card-header">
						<h3 class="card-title">Wilayah</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body p-0">
							@php
								$currentKec = request('kec');
							@endphp
							<ul class="nav nav-pills flex-column" id="wilayah_filter">
								<li class="nav-item">
									<a class="nav-link {{ $currentKec === '5171020' ? 'active' : '' }}" 
        							href="{{ $currentKec === '5171020' ? route('psikologs.index') : route('psikologs.index', ['kec' => '5171020']) }}" 
           							data-kec="5171020">
										<i class="far fa-circle text-danger"></i>
										Denpasar Timur
										<span class="badge bg-secondary float-right">{{ $counts['5171020'] ?? 0 }}</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link {{ $currentKec === '5171030' ? 'active' : '' }}" 
									href="{{ $currentKec === '5171030' ? route('psikologs.index') : route('psikologs.index', ['kec' => '5171030']) }}" 
									data-kec="5171030">
										<i class="far fa-circle text-warning"></i> Denpasar Barat
										<span class="badge bg-secondary float-right">{{ $counts['5171030'] ?? 0 }}</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link {{ $currentKec === '5171010' ? 'active' : '' }}" 
									href="{{ $currentKec === '5171010' ? route('psikologs.index') : route('psikologs.index', ['kec' => '5171010']) }}" 
									data-kec="5171010">
										<i class="far fa-circle text-primary"></i>
										Denpasar Selatan
										<span class="badge bg-secondary float-right">{{ $counts['5171010'] ?? 0 }}</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link {{ $currentKec === '5171031' ? 'active' : '' }}" 
									href="{{ $currentKec === '5171031' ? route('psikologs.index') : route('psikologs.index', ['kec' => '5171031']) }}" 
									data-kec="5171031">
										<i class="far fa-circle text-primary"></i>
										Denpasar Utara
										<span class="badge bg-secondary float-right">{{ $counts['5171031'] ?? 0 }}</span>
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
					@include('psikologs.table')
				</div>
				<!-- /.col -->
			</div>

				<div class="card">
						
				</div>
		</div>

@endsection
