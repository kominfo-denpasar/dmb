@extends('layouts.app')

@section('content') 
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Detail Konseling</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('admin/home-psikolog') }}">Dashboard Psikolog</a></li>
						<li class="breadcrumb-item active">Detail Konseling</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						@if(session('success'))
						<div class="alert alert-success alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							{{ session('success') }}
						</div>
						@endif
						@if(session('error'))
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							{{ session('error') }}
						</div>
						@endif
						@if($errors->any())
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h5><i class="icon fas fa-ban"></i>Mohon cek field!</h5>
							{!! implode('', $errors->all('<div>:message</div>')) !!}
						</div>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">

						<!-- Profile Image -->
						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<div class="text-center">
									<img class="profile-user-img img-fluid img-circle" src="https://avataaars.io/?avatarStyle=Circle&topType=LongHairNotTooLong&accessoriesType=Blank&hairColor=Black&facialHairType=Blank&clotheType=CollarSweater&clotheColor=Gray01&eyeType=Default&eyebrowType=Default&mouthType=Default&skinColor=Pale" alt="User profile picture">
								</div>

								<h3 class="profile-username text-center">{{$data->nama}}</h3>
								<p class="text-muted text-center">{{$data->nik}}</p>

								<strong><i class="fas fa-book mr-1"></i> Pendidikan</strong>
								<p class="text-muted">
									{{$data->pendidikan}}
								</p>

								<hr>
								<strong><i class="fas fa-briefcase mr-1"></i> Pekerjaan saat ini</strong>
								<p class="text-muted">
									{{$data->pekerjaan}}
								</p>

								<hr>
								<strong><i class="fas fa-phone mr-1"></i> Nomor HP</strong>
								<p class="text-muted">
									<a target="_BLANK" href="//wa.me/62{{$data->hp}}">
									(+62) {{$data->hp}}
									</a>
								</p>

								<hr>
								<strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
								<p class="text-muted">
									{{$data->alamat}}
								</p>

								<!-- <hr>
								<strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
								<p class="text-muted">
									<span class="tag tag-danger">UI Design</span>
									<span class="tag tag-success">Coding</span>
									<span class="tag tag-info">Javascript</span>
									<span class="tag tag-warning">PHP</span>
									<span class="tag tag-primary">Node.js</span>
								</p> -->

								<hr>
								<strong><i class="far fa-file-alt mr-1"></i> Riwayat Konseling</strong>
								@if($riwayat_konseling->isEmpty())
								<p class="text-muted">
									<small>- Belum ada data konseling lainnya -</small>
								</p>
								@else
								<ol class="text-muted">
									@foreach($riwayat_konseling as $r)
									<li><span>{{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y - h:i')}}</span>&nbsp; 
										<a href="{{url('admin/home-psikolog/konseling/'.$r->id)}}">
											<i class="fas fa-search fa-xs"></i>
										</a>
									</li>
									@endforeach
								</ol>
								@endif
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->

					</div>
					<!-- /.col -->
					<div class="col-md-9">
						<div class="card">
							<div class="card-header p-2">
								<ul class="nav nav-pills">
									<li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Informasi</a></li>
									<li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Keluhan & DASS-21</a></li>
									<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Input Data Konseling</a></li>
									<li class="nav-item"><a class="nav-link" href="#evaluasi" data-toggle="tab">Formulir Evaluasi</a></li>
								</ul>
							</div><!-- /.card-header -->
							<div class="card-body">
								<div class="tab-content">
									<div class="active tab-pane" id="activity">

										@if($data->status==0)
										<div class="alert alert-danger">
											<h5>Perhatian!</h5>
											<p>
												Konseling terhadap klien ini belum pernah dilakukan. Jika Anda ingin mengkonfirmasi konseling ini, pastikan jadwal sudah sesuai dengan mengklik salah satu tombol di bawah.
											</p>
										</div>
										<!-- .callout -->
										<div class="card card-primary shadow-md">
											<!-- /.card-header -->
											<div class="card-header">
												<h3 class="card-title">Jadwal Utama</h3>

												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
													<i class="fas fa-minus"></i>
													</button>
												</div>
												<!-- /.card-tools -->
											</div>
											<div class="card-body">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<td style="width:20%" class="text-right">Hari</td>
															<td><b>{{$data->hari}}</b></td>
														</tr>
														<tr>
															<td class="text-right">Jam</td>
															<td><b>{{$data->jamnya}} WITA</b></td>
														</tr>
													</tbody>
												</table>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->

										<div class="card card-info shadow-md">
											<!-- /.card-header -->
											<div class="card-header">
												<h3 class="card-title">Jadwal Alternatif</h3>

												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
													<i class="fas fa-minus"></i>
													</button>
												</div>
												<!-- /.card-tools -->
											</div>
											<div class="card-body">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<td style="width:20%" class="text-right">Tanggal</td>
															<td><b>{{ \Carbon\Carbon::parse($data->jadwal_alt_tgl)->format('d/m/Y')}}</b></td>
														</tr>
														<tr>
															<td class="text-right">Jam</td>
															<td><b>{{ \Carbon\Carbon::parse($data->jadwal_alt_jam)->format('h:i')}} WITA</b></td>
														</tr>
													</tbody>
												</table>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->

										<div class="card card-info shadow-md">
											<div class="card-body">
												<div class="btn-group float-right">
													<form action="{{route('backend.updateJadwal')}}" method="POST">
														@csrf
														<input type="hidden" name="keluhan_id" value="{{$data->keluhan_id}}">
														<input type="hidden" name="jenis" value="utama">
														<button type="submit" class="btn btn-primary">Konfirmasi Jadwal Utama</button>
													</form>
													<form action="{{route('backend.updateJadwal')}}" method="POST">
														@csrf
														<input type="hidden" name="keluhan_id" value="{{$data->keluhan_id}}">
														<input type="hidden" name="jenis" value="alternatif">
														<input type="hidden" name="jadwal_alt2_tgl" value="{{$data->jadwal_alt_tgl}}">
														<input type="hidden" name="jadwal_alt2_jam" value="{{$data->jadwal_alt_jam}}">
														<button type="submit" class="btn btn-info">Konfirmasi Jadwal Alternatif</button>
													</form>
												</div>
											</div>
										</div>
										<!-- /.card -->
										<hr>

										<div class="callout callout-info">
											<h5></h5>
											<p>
												Jika kedua tanggal di atas tidak dapat dilakukan, Anda dapat melakukan pengajuan ulang tanggal yang telah disepakati bersama klien di bawah ini.
											</p>
										</div>

										<form action="{{url('admin/home-psikolog/konseling/jadwal')}}" method="POST" class="form-horizontal">
											@csrf
											<input type="hidden" name="keluhan_id" value="{{$data->keluhan_id}}">
											
											<div class="form-group row">
												<label for="field" class="col-sm-2 col-form-label">Tanggal</label>
												<div class="col-sm-10">
													<input class="form-control" id="jadwal_alt2_tgl" type="date" name="jadwal_alt2_tgl">
												</div>
											</div>

											<div class="form-group row">
												<label for="field" class="col-sm-2 col-form-label">Jam</label>
												<div class="col-sm-10">
													<input class="form-control" id="jadwal_alt2_jam" type="time" name="jadwal_alt2_jam">
												</div>
											</div>
											<!-- <div class="form-group row">
												<div class="offset-sm-2 col-sm-10">
													<div class="checkbox">
														<label>
															<input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
														</label>
													</div>
												</div>
											</div> -->
											<div class="form-group row">
												<div class="offset-sm-2 col-sm-10">
													<button type="submit" class="btn btn-success">Submit Jadwal Ulang</button>
												</div>
											</div>
										</form>

										@elseif($data->status==1)
										<hr>
										<div class="alert alert-warning">
											<h5>Perhatian!</h5>
											<p>
												Konseling terhadap klien saat ini sedang dalam proses, mohon inputkan data konseling setelah selesai melakukan assessment pada tab "Input Data Konseling".
											</p>
										</div>
										<!-- .callout -->

										<div class="card card-info shadow-md">
											<!-- /.card-header -->
											<div class="card-header">
												<h3 class="card-title">Informasi Detail</h3>

												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
													<i class="fas fa-minus"></i>
													</button>
												</div>
												<!-- /.card-tools -->
											</div>
											<div class="card-body">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<td style="width:20%" class="text-right">Tanggal Konseling</td>
															<td><b>{{ \Carbon\Carbon::parse($data->jadwal_alt2_tgl)->format('d/m/Y')}}</b></td>
														</tr>
														<tr>
															<td class="text-right">Jam</td>
															<td><b>{{ \Carbon\Carbon::parse($data->jadwal_alt2_jam)->format('h:i')}} WITA</b></td>
														</tr>
														<tr>
															<td class="text-right">Waktu Dikonfirmasi</td>
															<td><b>{{ \Carbon\Carbon::parse($data->updated_at)->format('d/m/Y - h:i')}} WITA</b></td>
														</tr>
													</tbody>
												</table>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->

										<div class="card card-info shadow-md">
											<div class="card-body">
												<p>
													<b>Catatan:</b> Setelah selesai melakukan assessment, mohon untuk menginputkan data pada tab 'Input Data Konseling' supaya status konseling menjadi selesai. Formulir evaluasi dapat diisi oleh Klien pada tab 'Formulir Evaluasi'.
												</p>
											</div>
										</div>
										<!-- /.card -->

										@elseif($data->status==2)

										<hr>
										<div class="alert alert-success">
											<h5>Perhatian!</h5>
											<p>
												Konseling terhadap Klien ini sudah selesai dilakukan. Untuk laporan hasil assessment dapat dilihat dengan mengklik tombol di bawah.
											</p>
										</div>
										<!-- .callout -->

										<div class="card card-info shadow-md">
											<div class="card-body">
												<div class="btn-group float-right">
													<a href="{{url('admin/home-psikolog/konseling/laporan-detail/1')}}" class="btn btn-primary">Laporan Detail Konseling</a>
												</div>
											</div>
										</div>
										<!-- /.card -->

										@endif
									</div>
									<!-- /.tab-pane -->
									 
									<div class="tab-pane" id="timeline">
										<!-- The timeline -->
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Keluhan</h3>
											</div>
											<div class="card-body">
												<div class="callout callout-info">
													<p>Deskripsi: <b>{{$data->keluhan}}</b></p>
												</div>
												<!-- .callout -->

												<div class="callout callout-info">
													<p>Informasi lanjutan terkait keluhan</p>
													<ul>
														<li>Lama waktu Klien merasakan keluhan: <b>{{$data->waktu_kapan}}</b></li>
														<li>Tingkat nilai mengganggu pada aktivitas Klien: <b>{{$data->nilai_mengganggu}}</b></li>
													</ul>
												</div>
												<!-- .callout -->
											</div>
										</div>

										
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Skor DASS-21</h3>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
												<div class="row">
													<div class="col-lg-4 col-6">
														<!-- small card -->
														<div class="small-box bg-info">
															<div class="inner">
																<h3>{{$data->nilai_s}}</h3>

																<p>Kategori Stress</p>
															</div>
															<div class="icon">
																<i class="fas fa-user-plus"></i>
															</div>
														</div>
													</div>
													<!-- ./col -->
													<div class="col-lg-4 col-6">
														<!-- small card -->
														<div class="small-box bg-success">
															<div class="inner">
																<h3>{{$data->nilai_a}}</h3>

																<p>Kategori Anxiety</p>
															</div>
															<div class="icon">
																<i class="fas fa-user-plus"></i>
															</div>
														</div>
													</div>
													<!-- ./col -->
													<div class="col-lg-4 col-6">
														<!-- small card -->
														<div class="small-box bg-warning">
															<div class="inner">
																<h3>{{$data->nilai_d}}</h3>

																<p>Kategori Depression</p>
															</div>
															<div class="icon">
																<i class="fas fa-user-plus"></i>
															</div>
														</div>
													</div>
													<!-- ./col -->
													
													</div>
											</div>
											<!-- /.card-body -->
											</div>
									</div>
									<!-- /.tab-pane -->

									<div class="tab-pane" id="settings">
										<div class="callout callout-danger">
											<h5>Perhatian!</h5>
											<p>
											@if($data->status==0) 
												Mohon untuk mengkonfirmasi konseling pada tab 'informasi' terlebih dahulu sebelum menginputkan hasil konseling. 
											@elseif($data->status==2)
												Anda sudah menginputkan data konseling sebelumnya. Jika ingin mengubah data, silahkan inputkan kembali data yang baru.
											@else
												Anda sedang dalam proses konseling. Mohon untuk menginputkan data konseling setelah selesai melakukan assessment.
											@endif
											</p>
										</div>
										<!-- .callout -->

										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Form Input Data Konseling</h3>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												@if($data->status!=2)
												<form enctype="multipart/form-data" action="{{route('backend.storeHasil')}}" method="POST" class="form-horizontal">
												@else
												<form enctype="multipart/form-data" action="{{route('backend.updateHasil', $data->konseling_id)}}" method="POST" class="form-horizontal">
												@endif
													@csrf
													<input type="hidden" name="mas_id" value="{{$data->token}}">
													<input type="hidden" name="keluhan_id" value="{{$data->keluhan_id}}">
													<input type="hidden" name="konseling_id" value="{{$data->konseling_id}}">


													<div class="form-group row">
														<label for="inputExperience" class="col-sm-2 col-form-label">Hasil Assessment</label>
														<div class="col-sm-10">
															<textarea class="form-control" name="hasil" id="hasil" placeholder="hasil" @if($data->status==0)disabled @endif>{!!$data->hasil!!}</textarea>
															<small>Inputkan data berdasarkan field yang diminta</small>
														</div>
													</div>

													<div class="form-group row">
														<label for="masalah" class="col-sm-2 col-form-label">Masalah</label>
														<div class="col-sm-10">
															<!-- checkbox -->
															<div class="row">
																<div class="col-md-6">
																	@foreach($masalah as $m)
																	<div class="form-check">
																		<input name="masalah[]" value="{{$m->id}}" {{ in_array($m->id, $konseling_masalah) ? 'checked' : '' }} class="form-check-input" type="checkbox">
																		<label class="form-check-label">{{$m->nama}}</label>
																	</div>
																	@endforeach
																</div>
																<!-- <div class="col-md-6">
																	<div class="form-check">
																		<input class="form-check-input" type="checkbox">
																		<label class="form-check-label">Penyakit n</label>
																	</div>
																	<div class="form-check">
																		<input class="form-check-input" type="checkbox">
																		<label class="form-check-label">Penyakit n</label>
																	</div>
																	<div class="form-check">
																		<input class="form-check-input" type="checkbox">
																		<label class="form-check-label">Penyakit n</label>
																	</div>
																</div> -->
															</div>
														</div>
													</div>
													<div class="form-group row">
														<label for="inputExperience" class="col-sm-2 col-form-label">Kesimpulan</label>
														<div class="col-sm-10">
															<textarea name="kesimpulan" class="form-control" id="inputExperience" placeholder="kesimpulan" value="{{$data->kesimpulan}}" @if($data->status==0)disabled @endif>{!!$data->kesimpulan!!}</textarea>
															<small>Inputkan data berdasarkan field yang diminta</small>
														</div>
													</div>
													<div class="form-group row">
														<label for="inputExperience" class="col-sm-2 col-form-label">Saran</label>
														<div class="col-sm-10">
															<textarea name="saran" class="form-control" id="inputExperience" placeholder="saran" @if($data->status==0)disabled @endif>{!!$data->saran!!}</textarea>
															<small>Inputkan data berdasarkan field yang diminta</small>
														</div>
													</div>
													<div class="form-group row">
														<label for="customFile" class="col-sm-2 col-form-label">Dokumentasi</label>

														<div class="col-sm-10">
															@if($data->berkas_pendukung)
															<img class="img-fluid" src="{{asset('uploads/berkas_pendukung/'.$data->berkas_pendukung)}}">
															@endif
															<div class="custom-file">
																@if($data->status!=0)
																<input type="file" name="berkas_pendukung" class="custom-file-input form-control" id="customFile">
																<label class="custom-file-label" for="customFile">Pilih Berkas</label>
																@else
																<small>xxx</small>
																@endif
															</div>
															<small>Input file yang berekstensi jpg, jpeg dan png</small>
														</div>
													</div>
													<!-- <div class="form-group row">
														<div class="offset-sm-2 col-sm-10">
															<div class="checkbox">
																<label>
																	<input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
																</label>
															</div>
														</div>
													</div> -->
													<div class="form-group row">
														<div class="offset-sm-2 col-sm-10">
															<button type="submit" class="btn btn-success" @if($data->status==0)disabled @endif>Kirim Data</button>
														</div>
													</div>
												</form>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>
									<!-- /.tab-pane -->

									<div class="tab-pane" id="evaluasi">
										<div class="col-11">
											<div class="form-group">
												<label>Seberapa membantu layanan konseling yang diberikan?
												</label>
												<select class="form-control">
													<option>option 1</option>
													<option>option 2</option>
													<option>option 3</option>
													<option>option 4</option>
													<option>option 5</option>
												</select>
											</div>
											<div class="form-group">
												<label>Setelah konseling, seberapa mengganggu keluhan yang Anda rasakan pada aktivitas sehari-hari?
												</label>
												<select class="form-control">
													<option>option 1</option>
													<option>option 2</option>
													<option>option 3</option>
													<option>option 4</option>
													<option>option 5</option>
												</select>
											</div>
											<div class="form-group">
												<label>Apakah anda bersedia merekomendasikan layanan konseling ini ke rekan/keluarga yang membutuhkan?
												</label>
												<select class="form-control">
													<option>Pilih</option>
													<option>Bersedia</option>
													<option>Tidak Bersedia</option>
												</select>
											</div>
											<div class="btn-group float-right">
												<button type="button" class="btn btn-primary">Kirim Data</button>
											</div>
										</div>
										<!-- .col-11 -->
									</div>
									<!-- .evaluasi -->
								</div>
								<!-- .col-12 -->
								</div>
								<!-- /.tab-content -->
							</div><!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div><!-- /.container-fluid -->
		</section>
@endsection