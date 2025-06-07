@extends('front.layouts.app')

@section('content')
<style>
	button.swal2-styled {
		background: #000;
	}
	.border-red-100 {
		border-width: 4px;
		border-color: red;
	}
	.fc-event-title {
		font-weight: bold;
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

			<form id="konselingForm" method="POST" class="space-y-2">
				@csrf

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
							<p class="help">Pilih salah satu Psikolog dan pilih jadwal pada kalender yang akan muncul.</p>
						</div>
					</div>
				</div>
				<!-- .field -->

				<div class="field">
					<div class="field">
						<!-- <label class="label">Tanggal Konseling</label> -->
						<div class="field-body">
							<div class="field">
								<div id="calendar-container" class="w-full h-[600px] p-4">
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
				</div>
				<!-- .field -->

				<div id="dateUtamaDiv" class="hidden border rounded-md p-4 w-full mx-auto max-w-2xl">
					<label class="label">Jadwal Utama</label>
					<div class="field-body">
						<div class="field">
							<p id="dateUtama"></p>
							<p class="help">Pilih lagi jadwal pada kalender sebagai alternatif.</p>
						</div>
					</div>
				</div>

				<div id="timeModal" class="hidden field">
					<div class="border border-red-100 rounded-md p-4 w-full mx-auto max-w-2xl">
						<label class="label">Pilih Jam Konseling <span id="judul_modal"></span></label>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<p id="selectedDateLabel"></p>
									<input type="hidden" id="selectedDate" name="selectedDate">
									<div id="timeSlots" class="w-full p-2"></div>
								</div>
								<p class="help">Pilih jam konseling sesuai dengan tanggal yang telah dipilih</p>
							</div>
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
				</div>
				<!-- .field -->
				
			</form>
		</article>

	</div>
</section>

@endsection

@push('script')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- <script src="//phppot.com/demo/events-display-using-php-ajax-with-clndr-calendar-plugin/clndr.js"></script> -->
<script src='//cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
<script type="text/javascript">
	const calendarEl = document.getElementById('calendar');
	const modal = document.getElementById('timeModal');
	const psikolog = document.getElementById('psikolog_id');
	const utama = document.getElementById('dateUtamaDiv');

	const judulModal = document.getElementById("judul_modal");

	// Variabel global simpan dua pilihan
    let pilihanUtama = null;
    let pilihanAlternatif = null;

	document.querySelector('#psikolog_id').addEventListener('change', function() {
		modal.classList.add('hidden');
		modal.classList.remove('block');

		const opsi = document.querySelector('#psikolog_id').value;
		const url = `{{route('front.jadwal-psikolog', ':id')}}`.replace(':id', opsi);
		// console.log(url);

		fetch(url)
			.then((response) => {
				if (!response.ok) {
					throw new Error('Network response was not ok.');
				}
				return response.json();
			})
			.then((data) => {
				const calendar = new FullCalendar.Calendar(calendarEl, {
					initialView: 'dayGridMonth',
					locale: 'id',
					selectable: true,
					height: 'auto',
					headerToolbar: {
						left: 'prev,next today',
						center: 'title',
						right: '',
					},
					dateClick: function(info) {
						const date = info.dateStr;

						// Hapus highlight sebelumnya (jika ada)
						calendar.getEvents().forEach(event => {
							if (event.extendedProps.clickedHighlight) {
							event.remove();
							}
						});

						// Tambahkan background merah untuk tanggal yang diklik
						calendar.addEvent({
						start: date,
						display: 'background',
						backgroundColor: 'red',
						extendedProps: {
							clickedHighlight: true
						}
						});

						clickedDate = date;


						const match = data.find(d => d.date === date);
						if (match) {
							$('#selectedDate').val(date);
							$('#selectedDateLabel').text('Tanggal: ' + date);
							let buttons = '';
							match.times.forEach(time => {
								buttons += `<div class="form-check">
									<input class="form-check-input" type="radio" name="time" value="${time}" required>
									<label class="form-check-label">${time}</label>
								</div>`;
							});
							$('#timeSlots').html(buttons);
							modal.classList.remove('hidden');
							modal.classList.add('block');

							if (pilihanUtama) {
								judulModal.innerHTML = '';
								judulModal.textContent = 'Jadwal Alternatif';
							} else {
								judulModal.innerHTML = '';
								judulModal.textContent = 'Jadwal Utama';
							}

							// alert('Silakan pilih waktu yang tersedia untuk tanggal ini.');
							Swal.fire({
								text: "Silakan pilih waktu/sesi yang tersedia untuk tanggal ini di bawah.",
								icon: "info"
							});
						} else {
							modal.classList.add('hidden');
							modal.classList.remove('block');
							// alert('Tidak ada slot waktu tersedia untuk tanggal ini.');
							Swal.fire({
								text: "Tidak ada slot waktu tersedia untuk tanggal ini.",
								icon: "error"
							});
						}
					},
					events: data.map(d => ({
						// title: 'Tersedia',
						start: d.date,
						display: 'background',
						backgroundColor: 'rgb(146 188 255)',
					}))

				});
				calendar.render();

				if (window.innerWidth < 800) {
					calendar.Calendar('changeView', 'agendaDay');
				}
				// var calendarEl = document.getElementById('calendar');
				// var calendar = new FullCalendar.Calendar(calendarEl, {
				// 	locale: 'id',
				// 	initialView: 'dayGridMonth',
				// 	events: data,
				// 	eventClick: function(info) {
				// 		alert('clicked ' + info.event.title + ' ' + info.event.start);
				// 		info.el.style.backgroundColor = 'red';
				// 	},
				// 	select: function(info) {
				// 		alert('selected ' + info.startStr + ' to ' + info.endStr);
				// 	}
				// });
				// calendar.render();
			})
			.catch((error) => {
				return error;
			});
	});

	$('#konselingForm').on('submit', function(e) {
        e.preventDefault();
        const tanggal = $('#selectedDate').val();
        const jam = $('input[name="time"]:checked').val();

        if (!pilihanUtama) {
            pilihanUtama = { tanggal, jam };

			$('#dateUtama').text(tanggal);
			utama.classList.remove('hidden');
			utama.classList.add('block');

            // alert('Tanggal utama dipilih. Silakan pilih tanggal alternatif.');
			Swal.fire({
				text: "Jadwal utama dipilih. Silakan pilih jadwal alternatif.",
				icon: "success"
			});
            modal.classList.add('hidden');
			modal.classList.remove('block');
			psikolog.setAttribute("readonly", "readonly");
        } else if (pilihanUtama.tanggal === tanggal) {
			// alert('Tanggal utama dan alternatif tidak boleh sama.');
			Swal.fire({
				text: "Jadwal utama dan alternatif tidak boleh sama.",
				icon: "warning"
			});
			modal.classList.add('hidden');
			modal.classList.remove('block');
		} else {
            pilihanAlternatif = { tanggal, jam };
            modal.classList.add('hidden');
			modal.classList.remove('block');
            submitPilihan();
        }
    });

    function submitPilihan() {
		// Tampilkan popup loading dulu
		Swal.fire({
			title: 'Menyimpan...',
			text: 'Mohon tunggu sebentar',
			allowOutsideClick: false,
			allowEscapeKey: false,
			didOpen: () => {
				Swal.showLoading();
			}
		});
		
        $.ajax({
            url: "{{route('front.konseling-jadwal-store')}}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
				psikolog_id: $('#psikolog_id').val(),
				mas_id: '{{$masyarakat->token}}',
                utama: pilihanUtama,
                alternatif: pilihanAlternatif
            },
            success: function(response) {
                // alert('Pilihan berhasil disimpan!');
				Swal.fire({
					title: "Selamat!",
					text: "Jadwal Konseling berhasil disimpan.",
					icon: "success"
				}).then(function() {
					window.location = "{{route('front.konseling-jadwal', $masyarakat->token)}}";
				});
            },
            error: function(err) {
                Swal.fire({
					text: "Gagal menyimpan pilihan. Silakan coba lagi.",
					icon: "error"
				});
            }
        });
    }
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