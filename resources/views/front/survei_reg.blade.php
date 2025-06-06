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

			<div class="mt-4 mb-2 space-y-2">
				<div role="alert" class="rounded border-s-4 border-green-500 bg-green-50 p-4">
					<!-- <div class="flex items-center gap-2 text-green-800">
						<strong class="block font-medium"> Catatan</strong>
					</div> -->

					<p class="text-green-700">
						Halo, kami Tim Denpasar Menyama Bagia sangat mengapresiasi kepedulian Anda tentang kebutuhan kesehatan mental diri sendiri. Sebagai langkah kami untuk dapat mendukung Anda, kami mohon untuk mengisi data-data di bawah ini, Matur Suksma 🙏🏻
					</p>
				</div>
				
			</div>

			<form action="{{route('front.store-reg')}}" method="POST" class="space-y-2">
				@csrf
				<input type="hidden" name="mas_id" value="{{Session::get('mas_id')}}">

				<div class="field">
					<label class="label">Nama Lengkap</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="text" autocomplete="off" name="nama" placeholder="John Doe" class="input" required="">
							</div>
							<p class="help">Isi dengan nama lengkap Anda</p>
						</div>
					</div>
				</div>
				<!-- .field -->

				<div class="field">
					<label class="label">Jenis Kelamin</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<select name="jk" class="w-full p-2 input" required="">
									<option value="">Pilih</option>
									<option value="L">Laki-laki</option>
									<option value="P">Perempuan</option>
									<option value="N">Tidak ingin menyebutkan</option>
								</select>
							</div>
							<p class="help">Pilih salah satu</p>
						</div>
					</div>
				</div>
				<!-- .field -->

				<div class="field">
					<label class="label">Tanggal Lahir</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="date" autocomplete="off" name="tgl_lahir" class="input" required="">
							</div>
							<p class="help">Pilih tanggal</p>
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
									<input class="input" type="tel" placeholder="81xxx" value="{{Session::get('hp')}}" name="hp" readonly>
								</div>
							</div>
							<p class="help">Disarankan nomor yang terhubung dengan WhatsApp. Kami menggunakan WhatsApp untuk mengirimkan info ke Anda</p>
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
							Mulai Mengisi Survei
						</span>
					</button>
				</div>
			</form>
		</article>

	</div>
</section>
@endsection