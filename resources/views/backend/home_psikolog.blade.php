@extends('layouts.app')
@section('page-title', 'Dashboard-Psikolog')

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
			</div>
			<div class="col-lg-9">
				<div class="row">
					<div class="col-12 col-sm-6 col-md-4">
						<div class="info-box">
						<span class="info-box-icon bg-info elevation-1"><i class="fas fa-hourglass-start"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Konseling Menunggu</span>
							<span class="info-box-number">
								<h3>{{$dashboard['konseling_belum']}}</h3>
							</span>
						</div>
						<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-4">
						<div class="info-box">
						<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-spinner"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Konseling On Progress</span>
							<span class="info-box-number">
								<h3>{{$dashboard['konseling_on_progress']}}</h3>
							</span>
						</div>
						<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-4">
						<div class="info-box">
						<span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Konseling Selesai</span>
							<span class="info-box-number">
								<h3>{{$dashboard['konseling_selesai']}}</h3>
							</span>
						</div>
						<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
				</div>

				<div class="card">
					<div class="card-header border-0">
						<h3 class="card-title">
							<b>List Klien Registrasi Konseling</b>
						</h3>
						<div class="card-tools">
							<!-- <a href="#" class="btn btn-tool btn-sm">
								<i class="fas fa-bars"></i>
							</a> -->
						</div>
					</div>
					<div class="card-body table-responsive p-0">
						<table class="table table-striped table-valign-middle">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama Klien</th>
									<th>Tanggal Registrasi</th>
									<th>Status</th>
									<th>Opsi</th>
								</tr>
							</thead>
							<tbody>
							@if($keluhan->isEmpty())
								<tr>
									<td colspan="5" class="text-center">- Tidak ada data -</td>
								</tr>
							@endif
							@foreach($keluhan as $k)
								<tr @if($k->status == 0) class="table-danger" @endif>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $k->nama }}</td>
									<td>{{ \Carbon\Carbon::parse($k->created_at)->format('d/m/Y | h:i') }} WITA</td>
									<td>
										@if($k->status == 2)
											<span class="badge bg-success">Selesai</span>
										@elseif($k->status == 1)
											<span class="badge bg-warning">On Progress</span>
										@elseif($k->status == 3)
											<span class="badge bg-danger">Batal</span>
										@else
											<span class="badge bg-info">Menunggu</span>
										@endif
									</td>
									<td>
										<a href="{{ url('admin/home-psikolog/konseling/'.$k->id) }}" class="text-muted">
											<i class="fas fa-search"></i>
										</a>&nbsp;
										@if($k->status == 2)
											<a href="{{ route('backend.laporan-detail', $k->id) }}" class="text-muted">
												<i class="fas fa-print"></i>
											</a>
										@endif
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.card -->
			</div>
			<!-- .col-lg-6 -->

			<div class="col-lg-3">
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							@if($psikolog->foto)
							<img style="width: 100%;" class="profile-user-img img-fluid img-circle" src="{{asset('storage/uploads/psikolog/'.$psikolog->foto)}}" alt="User profile picture">
							@else
							<img style="width: 100%;" class="profile-user-img img-fluid img-circle" src="https://avataaars.io/?avatarStyle=Circle&topType=LongHairFrida&accessoriesType=Blank&hairColor=Black&facialHairType=Blank&clotheType=BlazerShirt&eyeType=Default&eyebrowType=Default&mouthType=Default&skinColor=Pale" alt="User profile picture">
							@endif
						</div>

						<h3 class="profile-username text-center">{{$psikolog->nama}}</h3>

						<p class="text-muted text-center">Psikolog</p>

						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
							<b>KTA</b> <a class="float-right">{{$psikolog->kta}}</a>
							</li>
							<li class="list-group-item">
							<b>SIPP</b> <a class="float-right">{{$psikolog->sipp}}</a>
							</li>
							<li class="list-group-item">
							<b>E-mail</b> <a class="float-right">{{$user->email}}</a>
							</li>
							<li class="list-group-item">
							<b>Nomor HP</b> <a class="float-right">(+62) {{$psikolog->hp}}</a>
							</li>
							<li class="list-group-item">
							<b>Alamat Praktek</b> <a class="float-right">{{$psikolog->alamat_praktek}}</a>
							</li>
						</ul>

						<a href="{{route('backend.profil')}}" class="btn btn-primary btn-block"><b>Detail Profil</b></a>
					</div>
					<!-- /.card-body -->
				</div>
			</div>
			<!-- .col-lg-6 -->
		</div>
	</div>
</section>
@endsection