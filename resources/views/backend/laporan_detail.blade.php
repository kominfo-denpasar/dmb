@extends('layouts.app')

@section('content') 
	<section class="content-header">
		<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
			<h1>Laporan Detail Konseling</h1>
			</div>
			<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard Psikolog</a></li>
				<li class="breadcrumb-item"><a href="{{route('backend.konseling', $data->keluhan_id)}}">Detail Konseling</a></li>
				<li class="breadcrumb-item active">Laporan Detail Konseling</li>
			</ol>
			</div>
		</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="callout callout-info">
						<h5><i class="fas fa-info"></i> Perhatian:</h5>
						Berikut adalah laporan detail konseling. Gunakan tombol export untuk mendownload dalam format PDF.
					</div>
				</div>
				<!-- .col-12 -->

				<div class="offset-2 col-8">
					<!-- Main content -->
					<div class="invoice p-3 mb-3">
					<!-- title row -->
					<div class="row">
						<div class="col-12">
						<h4>
							<i class="fas fa-globe"></i> Psychological Record.
							<small class="float-right">Tanggal: {{ \Carbon\Carbon::parse($data->tanggalnya)->format('d/m/Y')}}</small>
						</h4>
						</div>
						<!-- /.col -->
					</div>
					<!-- info row -->
					<div class="row invoice-info">
						<div class="col-sm-3 invoice-col">
						<address>
							<strong>Nama Pemeriksa<br>
							Nama Klien<br>
							Jenis Kelamin<br>
							Tanggal Lahir/Usia<br>
							Pendidikan Terakhir<br>
							Pekerjaan<br>
							Kecamatan<br></strong>	
						</address>
						</div>
						<!-- /.col -->
						<div class="col-sm-4 invoice-col">
						<address>
							:&nbsp; {{$data->psikolog_nama}}<br>
							:&nbsp; {{$data->nama}}<br>
							:&nbsp; {{$data->jk}}<br>
							:&nbsp; {{\Carbon\Carbon::parse($data->tgl_lahir)->format('d/m/Y')}}<br>
							:&nbsp; {{$data->pendidikan}}<br>
							:&nbsp; {{$data->pekerjaan}}<br>
							:&nbsp; {{App\Http\Controllers\PsikologController::kec($data->kec_id)}}<br>
						</address>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>A. Keluhan</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											{{$data->keluhan}}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th colspan="2">B. Masalah yang dialami</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td width="50%">
											[list masalah]
										</td>
										<td>
											[list deskripsi masalah]
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>C. Data Anamnesis</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											[data anamnesis]
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>D. Asesmen dan Hasil Pemeriksaan</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											{{$konseling->hasil}}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>E. Kesimpulan</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											{{$konseling->kesimpulan}}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>F. Saran</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											{{$konseling->saran}}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>G. Dokumentasi</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<img class="img-fluid" src="{{ asset('uploads/berkas_pendukung/'.$konseling->berkas_pendukung)}}" alt="Dokumentasi">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<div class="row">
						<!-- accepted payments column -->
						<div class="col-6">
						</div>
						<!-- /.col -->
						<div class="col-6 text-center mb-5">
							<p class="text-center" style="margin-bottom: 2px;font-weight:bold">Denpasar, {{\Carbon\Carbon::parse()->format('d M Y')}}</p>
							<p class="text-center well well-sm shadow-none" style="margin-top: 75px;margin-bottom: 0px;font-weight:bold">
								<u>({{$data->psikolog_nama}})</u>
							</p>
							<span class="text-muted">{{$data->sipp}}</span>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- this row will not appear when printing -->
					<div class="row no-print">
						<div class="col-12">
							<a href="{{url('admin/home-psikologi/print')}}" rel="noopener" target="_blank" class="btn btn-default float-right"><i class="fas fa-print"></i> Print</a>
							<button type="button" class="btn btn-secondary float-right" style="margin-right: 5px;">
								<i class="fas fa-download"></i> PDF
							</button>
						</div>
					</div>
					</div>
					<!-- /.invoice -->
				</div><!-- /.col -->
			</div>
		</div><!-- /.container-fluid -->
	</section>
@endsection