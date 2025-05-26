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

					<div class="d-flex flex-row justify-content-end">
						<span class="mr-2">
						<i class="fas fa-square text-primary"></i> Klien Survei DASS-21
						</span>

						<span>
						<i class="fas fa-square text-danger"></i> Klien Registrasi
						</span>
					</div>
				</div>
			</div>
			<!-- /.card -->

			<div class="card">
				<div class="card-header border-0">
					<h3 class="card-title">Hasil DASS-21</h3>
					<div class="card-tools">
						<a href="#" class="btn btn-tool btn-sm">
						<i class="fas fa-download"></i>
						</a>
						<a href="#" class="btn btn-tool btn-sm">
						<i class="fas fa-bars"></i>
						</a>
					</div>
				</div>
				<div class="card-body table-responsive p-0">
					<canvas id="dassChart"></canvas>
				</div>
			</div>
			<!-- /.card -->
			</div>
			<!-- /.col-md-6 -->
			<div class="col-lg-6">
			<div class="card">
				<div class="card-header border-0">
					<div class="d-flex justify-content-between">
						<h3 class="card-title">Jumlah Sesi Konseling</h3>
					</div>
				</div>
				<div class="card-body">

					<div class="position-relative mb-4">
						<canvas id="konselingChart" height="250" width="715" style="display: block; height: 200px; width: 572px;" class="chartjs-render-monitor"></canvas>
					</div>

				<div class="d-flex flex-row justify-content-end">
					<span class="mr-2">
						<i class="fas fa-square text-warning"></i> Sedang Proses
					</span>

					<span>
						<i class="fas fa-square text-success"></i> Selesai
					</span>
				</div>
				</div>
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
<script type="text/javascript" src="https://adminlte.io/themes/v3/dist/js/pages/dashboard3.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script>
fetch('https://dev-8.denpasarkota.go.id/dmb/admin/dashboard/data?year=2025')
    .then(res => res.json())
    .then(data => {
        const bulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

        // Klien per bulan
        new Chart(document.getElementById('clientChart'), {
            type: 'bar',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Klien Baru',
                    data: bulan.map((_, i) => data.clients[i+1] || 0),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                }]
            }
        });

        // DASS 21 Chart
        const kategori = Object.keys(data.dass);
        const colors = {
            normal: 'green',
            ringan: 'blue',
            sedang: 'orange',
            berat: 'red',
            sangat_berat: 'darkred'
        };

        new Chart(document.getElementById('dassChart'), {
            type: 'line',
            data: {
                labels: bulan,
                datasets: kategori.map(kat => ({
                    label: kat,
                    data: bulan.map((_, i) => data.dass[kat][i+1] || 0),
                    borderColor: colors[kat] || 'gray',
                    fill: false
                }))
            }
        });

        // Konseling
        new Chart(document.getElementById('konselingChart'), {
            type: 'bar',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Sesi Konseling',
                    data: bulan.map((_, i) => data.konseling[i+1] || 0),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                }]
            }
        });
    });
</script>
@endpush