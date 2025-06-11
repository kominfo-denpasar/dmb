@php
	$user = Auth::user();
	$defaultPhoto = asset('img/pp_user.jpg');
	$photoUrl = $defaultPhoto;

	if ($user->role === 'psikolog' && $user->psikolog && $user->psikolog->foto) {
		$path = 'uploads/psikolog/' . $user->psikolog->foto;
		if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
			$photoUrl = asset('storage/' . $path);
		}
	}
@endphp

{{-- Optional untuk debug --}}
{{-- <div>Path: {{ $path }}</div>
<div>Exists: {{ $fileExists ? 'Yes' : 'No' }}</div> --}}

<x-laravel-ui-adminlte::adminlte-layout>
	<!-- @push('head')
		@stack('third_party_stylesheets') {{-- Tambahkan CSS di HEAD --}}
	@endpush -->
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Header -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
								class="fas fa-bars"></i></a>
					</li>
				</ul>

				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
							<i class="far fa-question-circle"></i>
							<span class="badge badge-danger navbar-badge">!</span>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
						<a href="https://ndb.kreatifitas.site/dashboard/#/nc/form/4312a713-9b49-4248-8f5b-c110a87c4734" class="dropdown-item">
							<!-- Message Start -->
							
							<div class="media-body">
								<h3 class="dropdown-item-title">
								Pelaporan Bug
								<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
								</h3>
								<p class="text-sm">Saat ini aplikasi masih dalam tahap uji coba, jika dalam pengoperasian Bapak/Ibu menemukan kendala bug/error pada aplikasi. Mohon untuk mengirimkan informasi kepada kami melalui formulir pelaporan bug dengan cara mengklik tombol ini.</p>
								<!-- <p class="text-sm text-muted"><i class="far fa-user mr-1"></i> Support</p> -->
							</div>
							<!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="https://dcloud.denpasarkota.go.id" class="dropdown-item">
							<!-- Message Start -->
							
							<div class="media-body">
								<h3 class="dropdown-item-title">
								Buku Panduan
								</h3>
								<p class="text-sm">Cara pengoperasian sistem dapat Bapak/Ibu lihat dengan cara mengklik tombol ini.</p>
								<!-- <p class="text-sm text-muted"><i class="far fa-user mr-1"></i> Support</p> -->
							</div>
							<!-- Message End -->
						</a>
						
					</li>
					
					<li class="nav-item dropdown user-menu">
						<a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown">
							{{-- <img src="{{ $photoUrl }}"
								class="user-image img-circle elevation-2" alt="User Image"> --}}
							<i class="fas fa-user ml-1"></i>&nbsp; 
							<span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<!-- User image -->
							<li class="user-header bg-primary">
								@if(Auth::user()->psikolog_id && isset($psikolog) && $psikolog->foto)
								<img class="img-circle elevation-2" alt="User Image"
									src="{{ asset('storage/uploads/psikolog/' . $psikolog->foto) }}" 
									alt="Foto Psikolog">
								@else
									<img class="img-circle elevation-2" alt="User Image" 
										src="{{ asset('img/pp_user.jpg') }}" 
										alt="Foto Default User">
								@endif
								<p>
									{{ Auth::user()->name }}
									<small>Anggota sejak {{ Auth::user()->created_at->format('M. Y') }}</small>
								</p>
							</li>
							<!-- Menu Footer-->
							<li class="user-footer">
								<a href="{{route('backend.profil')}}" class="btn btn-default btn-flat">Profil</a>
								<a href="#" class="btn btn-default btn-flat float-right"
									onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									Keluar
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</li>
						</ul>
					</li>
				</ul>
			</nav>

			<!-- Left side column. contains the logo and sidebar -->
			@include('layouts.sidebar')

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper py-4 px-2">
				 <!-- Dynamic Page Header -->
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>@yield('page-title', 'Default Title')</h1>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
								@yield('breadcrumb')
								</ol>
							</div>
						</div>
					</div><!-- /.container-fluid -->
				</section>



				@yield('content')
			</div>

			<!-- Main Footer -->
			<footer class="main-footer">
				<!-- <div class="float-right d-none d-sm-block">
					<b>Version</b> 3.1.0
				</div>
				<strong>Copyright &copy; 2014-2023 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
				reserved. -->
				<strong>Copyright &copy; <a target="_BLANK" href="https://spbe.denpasarkota.go.id">SPBE Kominfos Kota Denpasar</a>.</strong>
			</footer>
		</div>
	</body>
</x-laravel-ui-adminlte::adminlte-layout>
