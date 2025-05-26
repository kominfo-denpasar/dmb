@extends('layouts.app')

@section('content') 
<style>
	.card-title {
		font-size: 1.5rem;
		font-weight: bold;
	}
</style>

<div class="container-fluid"> 
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header border-0">
					<h3 class="card-title">Selamat Datang di DMB (Denpasar Menyama Bagia)</h3>
					<div class="card-tools">
						<a href="#" class="btn btn-tool btn-sm">
							<i class="fas fa-question-mark"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					Selamat datang di sistem informasi DMB. Di sini Anda dapat mengelola data klien, survei, dan sesi konseling dengan mudah.
				</div>
			</div>
			<!-- /.card -->

			<!-- filter laporan -->
			<div class="card">
				<div class="card-body row">
					<div class="filters mb-2 col-lg-6">
						<label for="filter-year">Tahun:</label>
						<select class="form-control" id="filter-year">
							@for ($y = date('Y'); $y >= 2024; $y--)
								<option value="{{ $y }}">{{ $y }}</option>
							@endfor
						</select>
					</div>
					<div class="filters mb-1 col-lg-6">
						<label for="filter-month">Bulan:</label>
						<select class="form-control" id="filter-month">
							<option value="">Semua</option>
							@foreach (['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'] as $val => $label)
								<option value="{{ $val }}">{{ $label }}</option>
							@endforeach
						</select>
					</div>
					<div class="mb-1 col-lg-12">
						<small class="text-muted">Pilih tahun dan bulan untuk melihat laporan yang relevan.</small>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header border-0">
					<div class="d-flex justify-content-between">
						<h3 class="card-title">Klien Survei dan Registrasi</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="position-relative mb-4">
						<canvas id="clientChart" height="250" width="715" style="display: block; height: 200px; width: 572px;" class="chartjs-render-monitor"></canvas>
					</div>

				</div>
			</div>
			<!-- /.card -->

			<div class="card">
				<div class="card-header border-0">
					<div class="d-flex justify-content-between">
						<h3 class="card-title">Sesi Konseling</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="position-relative mb-4">
						<canvas id="konselingChart" height="250" width="715" style="display: block; height: 200px; width: 572px;" class="chartjs-render-monitor"></canvas>
					</div>

				</div>
			</div>
			<!-- /.card -->
		</div>
		<!-- /.col-md-6 -->


		<div class="col-lg-6">
			<div class="card">
				<div class="card-header border-0">
					<h3 class="card-title">Hasil Total DASS-21</h3>
					<div class="card-tools">
						<!-- <a href="#" class="btn btn-tool btn-sm">
						<i class="fas fa-download"></i>
						</a>
						<a href="#" class="btn btn-tool btn-sm">
						<i class="fas fa-bars"></i>
						</a> -->
					</div>
				</div>
				<div class="card-body table-responsive">
					<div class="mb-3">
						<label for="kategori">Pilih Kategori:</label>
						<select class="form-control" id="kategori" class="form-select w-25" onchange="updatePieChart()">
							<option value="Depresi">Depresi</option>
							<option value="Anxiety">Anxiety</option>
							<option value="Stress">Stress</option>
						</select>
					</div>
					<canvas id="dassPieChart"></canvas>
				</div>
			</div>
			<!-- /.card -->

			<div class="card">
				
			</div>
			<!-- /.card -->

		</div>
		<!-- /.col-md-6 -->

	</div>
</div>

@endsection

@push('page_scripts')
<!-- <script type="text/javascript" src="{{asset('js/chart.sample.min.js')}}"></script> -->
<script src="//code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript" src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>
<!-- <script type="text/javascript" src="https://adminlte.io/themes/v3/dist/js/pages/dashboard3.js"></script> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script>
const bulanLabel = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

let clientChart, konselingChart;

function updateCharts(data) {
    // Destroy existing charts if they exist
    if (clientChart) clientChart.destroy();
    if (konselingChart) konselingChart.destroy();

    // Klien
    const clientStatuses = { 0: 'Survei', 1: 'Konseling' };
	clientChart = new Chart(document.getElementById('clientChart'), {
		type: 'line',
		data: {
			labels: bulanLabel,
			datasets: Object.keys(clientStatuses).map(status => ({
				label: clientStatuses[status],
				data: bulanLabel.map((_, i) => data.clients[status]?.[i + 1] || 0),
				borderColor: status == 0 ? 'orange' : 'blue',
			}))
		}
	});

    // Konseling
    const konselingStatuses = {
    	0: 'Menunggu', 1: 'On Progress', 2: 'Selesai', 3: 'Batal'
	};
	const konselingColors = ['blue', 'orange', 'green', 'red'];

	konselingChart = new Chart(document.getElementById('konselingChart'), {
		type: 'bar',
		data: {
			labels: bulanLabel,
			datasets: Object.keys(konselingStatuses).map(status => ({
				label: konselingStatuses[status],
				data: bulanLabel.map((_, i) => data.konseling[status]?.[i + 1] || 0),
				backgroundColor: konselingColors[status]
			}))
		},
		options: {
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						stepSize: 1,
						callback: function(value) {
							return Number.isInteger(value) ? value : null;
						}
					}
				}
			}
		}
	});

	// fungsi warna berdasarkan level dass21
	function getColorByLevel(level) {
		switch (level) {
			case 'Normal': return 'green';
			case 'Mild': return 'blue';
			case 'Moderate': return 'orange';
			case 'Severe': return 'red';
			case 'Extremely Severe': return 'black';
			default: return 'gray';
		}
	}
}

// Fetch data on load & on filter change
function fetchData() {
    const year = document.getElementById('filter-year').value;
    const month = document.getElementById('filter-month').value;

    fetch(`https://dev-8.denpasarkota.go.id/dmb/admin/dashboard/data?year=${year}&month=${month}`)
        .then(res => res.json())
        .then(updateCharts);
}

document.getElementById('filter-year').addEventListener('change', fetchData);
document.getElementById('filter-month').addEventListener('change', fetchData);

// Initial load
fetchData();

// Pie Chart DASS-21
const dassPieData = @json($dassPie);

let chart = null;

function updatePieChart() {
	const kategori = document.getElementById('kategori').value;
	const dataKategori = dassPieData[kategori] || {};

	const labels = Object.keys(dataKategori);
	const data = Object.values(dataKategori);

	const warna = [
		'#4caf50', '#2196f3', '#ffc107',
		'#f44336', '#9c27b0', '#795548',
		'#00bcd4', '#ff5722'
	];

	const ctx = document.getElementById('dassPieChart').getContext('2d');

	if (chart) chart.destroy();

	chart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: labels,
			datasets: [{
				data: data,
				backgroundColor: warna.slice(0, labels.length),
				borderColor: '#fff',
				borderWidth: 1
			}]
		},
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: `Distribusi ${kategori} (DASS-21)`
				},
				legend: {
					position: 'bottom'
				}
			}
		}
	});
}

document.addEventListener("DOMContentLoaded", updatePieChart);

</script>

@endpush