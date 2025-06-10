@extends('front.layouts.app')

@section('content')

<section class="section main-section">

	<div class="max-w-2xl mx-auto px-4 py-12 sm:px-6">
		<article class="rounded-xl border border-gray-200 bg-white p-4 shadow-lg md:px-8">
			<div class="flex items-center">
				<img
				alt=""
				src="https://img.freepik.com/free-vector/man-with-ladder-flat-composition-with-view-doodle-human-characters-running-stairs-with-gears-vector-illustration_98292-9928.jpg?t=st=1739032268~exp=1739035868~hmac=fd1e1777d6ff6ae7f4fb771a68bfe2217f080c83bb3f9159cbd5670b80cf11e6&w=1380"
				class="sm:h-60 mx-auto"
				/>
			<div>
			</div>
			</div>

			<h2 class="text-2xl font-bold mb-6 text-center">Pendaftaran Konseling Selesai</h2>
			
			<div class="mt-4 mb-2 space-y-2">
				<div role="alert" class="rounded border-s-4 border-blue-500 bg-blue-50 p-4">
					<!-- <div class="flex items-center gap-2 text-green-800">
						<strong class="block font-medium"> Catatan</strong>
					</div> -->

					<p class="text-blue-700">
						Terima kasih telah melakukan pendaftaran konseling. Berikut adalah informasi yang perlu Anda ketahui! Data pendaftaran konseling Anda dapat dilihat di bawah ini dan juga telah dikirim ke Whatsapp & email Anda.
					</p>
				</div>
			</div>

			<ul class="max-w-2xl mx-auto my-5 divide-y shadow shadow-blue-600 rounded-xl">
				<li>
					<details class="group" open>
						<summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
							<svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
								width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
								<path fill-rule="evenodd"
									d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
								</path>
							</svg>
							<span>Data Pendaftaran Konseling Anda</span>
						</summary>

						<article class="px-4 pb-4">
						<div class="card has-table">
							<header class="card-header">
								<p class="card-header-title">
									<!-- <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
									Clients -->
								</p>
								<!-- <a href="#" class="card-header-icon">
									<span class="icon"><i class="mdi mdi-printer"></i></span>
								</a> -->
							</header>
							<div class="card-content">
								<table>
									<!-- <thead>
									<tr>
										<th></th>
										<th>Name</th>
										<th>Company</th>
										
									</tr>
									</thead> -->
									<tbody>
										<tr>
											<td data-label="Kolom" class="text-right">Nama</td>
											<td class="text-center" style="width:5%">:</td>
											<td data-label="Deskripsi" class="font-bold">{{$masyarakat->nama}}</td>
										</tr>
										<tr>
											<td data-label="Kolom" class="text-right">Nomor HP</td>
											<td class="text-center">:</td>
											<td data-label="Deskripsi" class="font-bold">0{{$masyarakat->hp}}</td>
										</tr>
										<tr>
											<td data-label="Kolom" class="text-right">Keluhan</td>
											<td class="text-center">:</td>
											<td data-label="Deskripsi" class="font-bold">{{$masyarakat->keluhan}}</td>
										</tr>
										<tr>
											<td colspan="3" class="text-center">
												<p>---</p>
											</td>
										</tr>
										<tr>
											<td data-label="Kolom" class="text-right">Tanggal</td>
											<td class="text-center">:</td>
											<td data-label="Deskripsi" class="font-bold">{{ \Carbon\Carbon::parse($masyarakat->jadwal_tgl)->format('d/m/Y')}}</td>
										</tr>
										<!-- <tr>
											<td data-label="Kolom" class="text-right">Hari Konseling</td>
											<td class="text-center">:</td>
											<td data-label="Deskripsi" class="font-bold">{{$masyarakat->hari}}</td>
										</tr> -->
										<tr>
											<td data-label="Kolom" class="text-right">Jam</td>
											<td class="text-center">:</td>
											<td data-label="Deskripsi" class="font-bold">{{$masyarakat->jadwal_jam}} WITA</td>
										</tr>
										<tr>
											<td colspan="3" class="text-center">
												<p>---</p>
											</td>
										</tr>
										<tr>
											<td data-label="Kolom" class="text-right">Psikolog</td>
											<td class="text-center">:</td>
											<td data-label="Deskripsi" class="font-bold">{{$masyarakat->psikolog}}</td>
										</tr>
										<tr>
											<td data-label="Kolom" class="text-right">Kontak</td>
											<td class="text-center">:</td>
											<td data-label="Deskripsi" class="font-bold">{{$masyarakat->psikolog_hp}}</td>
										</tr>
										<tr>
											<td data-label="Kolom" class="text-right">Alamat</td>
											<td class="text-center">:</td>
											<td data-label="Deskripsi" class="font-bold">{{$masyarakat->alamat_praktek}}</td>
										</tr>
									</tbody>
								</table>
							</div>
							</div>
						</article>
					</details>
				</li>
				<li>
					<details class="group">
						<summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
							<svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
								width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
								<path fill-rule="evenodd"
									d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
								</path>
							</svg>
							<span>Apa langkah selanjutnya?</span>
						</summary>

						<article class="px-4 pb-4">
							<p>{!!$selanjutnya->value!!}</p>
						</article>
					</details>
				</li>
				<li>
					<details class="group">
						<summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
							<svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
								width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
								<path fill-rule="evenodd"
									d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
								</path>
							</svg>
							<span>Bagaimana jika jadwal konseling sudah lewat?</span>
						</summary>

						<article class="px-4 pb-4">
							<p>
								{!!$jika_lewat->value!!} </p>
						</article>
					</details>
				</li>

			</ul>

		</article>

	</div>
</section>

@include('front.modals.survei')
@endsection