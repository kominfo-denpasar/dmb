@extends('front.layouts.app')

@section('content')

<section class="section main-section">

	<div class="max-w-2xl mx-auto px-4 py-12 sm:px-6">
		<article class="rounded-xl border border-gray-200 bg-white p-4 shadow-lg md:px-8">
				<div class="flex items-center">
					<img
					alt=""
					src="https://img.freepik.com/free-vector/woman-teaching-boy-with-maracas_74855-5966.jpg?t=st=1737948234~exp=1737951834~hmac=975b3e4020a8f6e9242638b86d30bad4321c5b6bfc0df060f05cc2a12f77c630&w=1380"
					class="sm:h-60 mx-auto"
					/>
				<div>
				</div>
			</div>

			@if($message = Session::get("warning"))
			<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mt-2" role="alert">
				<strong class="font-bold">Info: </strong>
				<span class="block sm:inline">{{$message}}</span>
			</div>
			@endif

			<h2 class="text-2xl font-bold mb-6 text-center">Formulir Evaluasi</h2>

			<div class="mt-4 mb-2 space-y-2">
				<div role="alert" class="rounded border-s-4 border-green-500 bg-green-50 p-4">
					<!-- <div class="flex items-center gap-2 text-green-800">
						<strong class="block font-medium"> Catatan</strong>
					</div> -->

					<p class="text-green-700">
						Silahkan pilih dan isi form evaluasi di bawah ini. Feedback dari Anda akan sangat membantu kami untuk memperbaiki layanan ke depannya. Pastikan data yang Anda masukkan benar dan valid.
					</p>
				</div>
				
			</div>

			<form action="{{route('front.store-evaluasi')}}" method="POST" class="space-y-2">
				@csrf
				<input type="hidden" name="mas_id" value="{{$mas_id}}">
				<input type="hidden" name="psikolog_id" value="{{$masyarakat->psikolog_id}}">
				<input type="hidden" name="keluhan_id" value="{{$masyarakat->keluhan_id}}">

				<div class="field">
					<label class="label">Nama Lengkap</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="text" autocomplete="off" value="{{$masyarakat->nama}}" class="input" readonly>
							</div>
						</div>
					</div>
				</div>
				<!-- .field -->

				<div class="field">
					<label class="label">Nomor HP</label>
					<div class="field-body">
						<div class="field">
							<div class="field addons">
								<!-- <div class="control">
									<input class="input" value="+62" size="2" readonly="">
								</div> -->
								<div class="control expanded">
									<input class="input" type="tel" value="{{$masyarakat->hp}}" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- .field -->

				<br>
				<hr>
				</br>

				<div class="field">
					<label class="label">Seberapa membantu layanan konseling yang diberikan?</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<select name="nilai_layanan" class="w-full p-2 input" required="">
									<option value="">Pilih</option>
									<option value="4">Sangat Membantu</option>
									<option value="3">Membantu</option>
									<option value="2">Cukup Membantu</option>
									<option value="1">Kurang Membantu</option>
								</select>
							</div>
							<p class="help">Pilih salah satu</p>
						</div>
					</div>
				</div>
				<!-- .field -->

				<div class="field">
					<label class="label">Setelah konseling, seberapa mengganggu keluhan yang Anda rasakan pada aktivitas sehari-hari?</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<select name="nilai_keluhan" class="w-full p-2 input" required="">
									<option value="">Pilih</option>
									<option value="4">Sangat mengganggu</option>
									<option value="3">Mengganggu</option>
									<option value="2">Cukup Mengganggu</option>
									<option value="1">Tidak Mengganggu</option>
								</select>
							</div>
							<p class="help">Pilih salah satu</p>
						</div>
					</div>
				</div>
				<!-- .field -->

				<div class="field">
					<label class="label">Apakah anda bersedia merekomendasikan layanan konseling ini ke rekan/keluarga yang membutuhkan?</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<select name="rekomendasi" class="w-full p-2 input" required="">
									<option value="">Pilih</option>
									<option value="1">Bersedia</option>
									<option value="0">Tidak Bersedia</option>
								</select>
							</div>
							<p class="help">Pilih salah satu</p>
						</div>
					</div>
				</div>
				<!-- .field -->

				

				<!-- <div class="field">
					<label class="label">e-mail</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="email" autocomplete="off" name="email" placeholder="nama@gmail.com" class="input" required="">
							</div>
							<p class="help">e-mail Anda yang masih aktif. Kami juga menggunakan e-mail untuk menyampaikan informasi</p>
						</div>
					</div>
				</div> -->
				<!-- .field -->

				<div class="space-y-2 text-center">
					<!-- Base -->
					<button type="submit" class="mt-4 mb-2 group relative inline-block focus:outline-none focus:ring">
						<span
							class="absolute inset-0 translate-x-1.5 translate-y-1.5 bg-yellow-300 transition-transform group-hover:translate-x-0 group-hover:translate-y-0"
						></span>

						<span
							class="relative inline-block border-2 border-current px-8 py-3 text-sm font-bold tracking-widest text-black group-active:text-opacity-75">
							Kirim Data
						</span>
					</button>
				</div>
			</form>
		</article>

	</div>
</section>
@endsection