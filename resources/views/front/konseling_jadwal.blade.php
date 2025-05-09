@extends('front.layouts.app')

@section('content')
<style>
	#calendar {
		max-width: 1100px;
		margin: 0 auto;
	}
	.fc-daygrid-event {
		background-color: #4a90e2;
		color: white;
		border-radius: 5px;
		padding: 5px;
		text-align: center;
	}
	.fc-daygrid-event:hover {
		background-color: #357ABD;
	}
	.fc-daygrid-event:active {
		background-color: #2A6496;
	}
	.fc-daygrid-event.fc-daygrid-event-start {
		border-top-left-radius: 5px;
		border-bottom-left-radius: 5px;
	}
	.fc-daygrid-event.fc-daygrid-event-end {
		border-top-right-radius: 5px;
		border-bottom-right-radius: 5px;
	}
	.fc-daygrid-event.fc-daygrid-event-start.fc-daygrid-event-end {
		border-radius: 5px;
	}
</style>


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
				<div role="alert" class="rounded border-s-4 border-blue-500 bg-blue-50 p-4">
					<!-- <div class="flex items-center gap-2 text-green-800">
						<strong class="block font-medium"> Catatan</strong>
					</div> -->

					<p class="text-blue-700">
						Silahkan untuk memilih jadwal dan psikolog yang Anda inginkan. Pastikan jadwal yang Anda pilih sudah sesuai dengan jadwal yang tersedia.
					</p>
				</div>
			</div>

			<form action="{{route('front.konseling-jadwal-store')}}" method="POST" class="space-y-2">
				@csrf

				<input type="hidden" name="mas_id" value="{{$masyarakat->token}}">
				<div class="field">
					<label class="label">Pilih Psikolog</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<select name="psikolog_id" id="psikolog_id" class="w-full p-2 input" required="">
									<option value="">Pilih</option>
									@foreach($psikolog as $data)
										<option value="{{$data->id}}">{{$data->nama}}</option>
									@endforeach
								</select>
							</div>
							<p class="help">Pilih salah satu Psikolog yang Anda inginkan</p>
						</div>
					</div>
				</div>
				<!-- .field -->

				<div class="field">
					<div class="field">
						<label class="label">Tanggal Konseling</label>
						<div class="field-body">
							<div class="field">
								<div class="container">
									<div id="calendar"></div>
								</div>
							</div>
							<!-- <div class="field">
								<div class="control">
									<input type="date" autocomplete="off" name="jadwal_tgl" class="input" required="">
								</div>
								<p class="help">Pilih tanggal kapan Anda ingin melakukan konseling</p>
							</div> -->
						</div>
					</div>
					<!-- .field -->
					<label class="label">Jam Konseling</label>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="time" id="jadwal_jam" class="w-full p-2 input" required="">
							</div>
							<p class="help">Pilih psikolog dahulu sebelum memilih jam konseling</p>
						</div>
					</div>
					
				</div>
				<!-- .field -->

				<div class="border rounded-md p-4 w-full mx-auto max-w-2xl">
					<div class="field">
						<label class="label">Alternatif Tanggal Konseling</label>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<input type="date" autocomplete="off" name="jadwal_alt_tgl" class="input" required="">
								</div>
								<p class="help">Pilih tanggal kapan Anda ingin melakukan konseling</p>
							</div>
						</div>
					</div>
					<!-- .field -->

					<div class="field">
						<label class="label">Alternatif Jam Konseling</label>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<input type="time" autocomplete="off" name="jadwal_alt_jam" class="input" required="">
								</div>
								<p class="help">Pilih jam kapan Anda ingin melakukan konseling</p>
							</div>
						</div>
					</div>

					<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mt-2" role="alert">
						<strong class="font-bold">Info: </strong>
						<span class="block sm:inline">Isi alternatif jika misalkan tanggal dan jam utama tidak bisa/available</span>
					</div>
				</div>

				<div class="space-y-2 text-center">
					<!-- Base -->
					<button type="submit" class="mt-4 mb-2 group relative inline-block focus:outline-none focus:ring">
						<span
							class="absolute inset-0 translate-x-1.5 translate-y-1.5 bg-yellow-300 transition-transform group-hover:translate-x-0 group-hover:translate-y-0"
						></span>

						<span
							class="relative inline-block border-2 border-current px-8 py-3 text-sm font-bold tracking-widest text-black group-active:text-opacity-75">
							Submit Data
						</span>
					</button>
				</div>
			</form>
		</article>

	</div>
</section>

@include('front.modals.survei')
@endsection

@push('script')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="//phppot.com/demo/events-display-using-php-ajax-with-clndr-calendar-plugin/clndr.js"></script>

<script src='//cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
<script type="text/javascript">
	const opsi = document.querySelector('#psikolog_id').value;
	document.addEventListener('DOMContentLoaded', function() {
		var calendarEl = document.getElementById('calendar');
		var calendar = new FullCalendar.Calendar(calendarEl, {
			locale: 'id',
			initialView: 'dayGridMonth',
			events: [
				{
					title  : 'Available',
					start  : '2025-05-05'
				},
				{
					title  : 'Available',
					start  : '2025-05-10'
				}
			],
			dateClick: function(info) {
				alert('clicked ' + info.dateStr);
			},
			select: function(info) {
				alert('selected ' + info.startStr + ' to ' + info.endStr);
			}
		});
		calendar.render();
	});

</script>

<script type="text/javascript">
	// document.querySelector('#psikolog_id').addEventListener('change', function() {
	// 	const opsi = document.querySelector('#psikolog_id').value;

	// 	const url = `{{route('front.jadwal-psikolog', ':id')}}`.replace(':id', opsi);

	// 	fetch(url)
	// 		.then((response) => {
	// 			if (!response.ok) {
	// 				throw new Error('Network response was not ok.');
	// 			}
	// 			return response.json();
	// 		})
	// 		.then((data) => {
	// 			// console.log(data);
	// 			const containerDisplay = document.getElementById('jadwal_id');
	// 			containerDisplay.innerHTML = "<option value=''>Pilih</option>";
	// 			data.forEach(result => {
	// 				const data = `
	// 					<option value="${result.id}">Hari ${result.hari}, jam ${result.jam} WITA</option>
	// 				`
	// 				containerDisplay.insertAdjacentHTML('afterbegin', data)
	// 			});
	// 		})
	// 		.catch((error) => {
	// 			return error;
	// 		});
	// });
</script>


@endpush