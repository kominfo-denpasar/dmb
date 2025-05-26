@extends('layouts.app')

@section('content') 

<div class="container-fluid"> 
	<div class="row">
		<?php
		/*
		<div class="col-lg-6">
		<div class="card">
			<div class="card-header border-0">
			<div class="d-flex justify-content-between">
				<h3 class="card-title">Jumlah Klien Survei DASS-21 & Konseling</h3>
				<a href="javascript:void(0);">Lihat </a>
			</div>
			</div>
			<div class="card-body">
			<div class="d-flex">
				<p class="d-flex flex-column">
				<span class="text-bold text-lg">820</span>
				<span>Visitors Over Time</span>
				</p>
				<p class="ml-auto d-flex flex-column text-right">
				<span class="text-success">
					<i class="fas fa-arrow-up"></i> 12.5%
				</span>
				<span class="text-muted">Since last week</span>
				</p>
			</div>
			<!-- /.d-flex -->

			<div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
				<canvas id="visitors-chart" height="250" width="715" style="display: block; height: 200px; width: 572px;" class="chartjs-render-monitor"></canvas>
			</div>

			<div class="d-flex flex-row justify-content-end">
				<span class="mr-2">
				<i class="fas fa-square text-primary"></i> This Week
				</span>

				<span>
				<i class="fas fa-square text-gray"></i> Last Week
				</span>
			</div>
			</div>
		</div>
		<!-- /.card -->

		<div class="card">
			<div class="card-header border-0">
			<h3 class="card-title">Klien terakhir yang melakukan konseling</h3>
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
			<table class="table table-striped table-valign-middle">
				<thead>
				<tr>
				<th>Nama</th>
				<th>Tanggal</th>
				<th>Status</th>
				<th>Opsi</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<td>
					<img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
					Some Product
				</td>
				<td>$13 USD</td>
				<td>
					<small class="text-success mr-1">
					<i class="fas fa-arrow-up"></i>
					12%
					</small>
					12,000 Sold
				</td>
				<td>
					<a href="#" class="text-muted">
					<i class="fas fa-search"></i>
					</a>
				</td>
				</tr>
				<tr>
				<td>
					<img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
					Another Product
				</td>
				<td>$29 USD</td>
				<td>
					<small class="text-warning mr-1">
					<i class="fas fa-arrow-down"></i>
					0.5%
					</small>
					123,234 Sold
				</td>
				<td>
					<a href="#" class="text-muted">
					<i class="fas fa-search"></i>
					</a>
				</td>
				</tr>
				<tr>
				<td>
					<img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
					Amazing Product
				</td>
				<td>$1,230 USD</td>
				<td>
					<small class="text-danger mr-1">
					<i class="fas fa-arrow-down"></i>
					3%
					</small>
					198 Sold
				</td>
				<td>
					<a href="#" class="text-muted">
					<i class="fas fa-search"></i>
					</a>
				</td>
				</tr>
				<tr>
				<td>
					<img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
					Perfect Item
					<span class="badge bg-danger">NEW</span>
				</td>
				<td>$199 USD</td>
				<td>
					<small class="text-success mr-1">
					<i class="fas fa-arrow-up"></i>
					63%
					</small>
					87 Sold
				</td>
				<td>
					<a href="#" class="text-muted">
					<i class="fas fa-search"></i>
					</a>
				</td>
				</tr>
				</tbody>
			</table>
			</div>
		</div>
		<!-- /.card -->
		</div>
		<!-- /.col-md-6 -->
		<div class="col-lg-6">
		<div class="card">
			<div class="card-header border-0">
			<div class="d-flex justify-content-between">
				<h3 class="card-title">Data DASS-21</h3>
				<a href="javascript:void(0);">Lihat</a>
			</div>
			</div>
			<div class="card-body">
			<div class="d-flex">
				<p class="d-flex flex-column">
				<span class="text-bold text-lg">$18,230.00</span>
				<span>Sales Over Time</span>
				</p>
				<p class="ml-auto d-flex flex-column text-right">
				<span class="text-success">
					<i class="fas fa-arrow-up"></i> 33.1%
				</span>
				<span class="text-muted">Since last month</span>
				</p>
			</div>
			<!-- /.d-flex -->

			<div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
				<canvas id="sales-chart" height="250" width="715" style="display: block; height: 200px; width: 572px;" class="chartjs-render-monitor"></canvas>
			</div>

			<div class="d-flex flex-row justify-content-end">
				<span class="mr-2">
				<i class="fas fa-square text-primary"></i> This year
				</span>

				<span>
				<i class="fas fa-square text-gray"></i> Last year
				</span>
			</div>
			</div>
		</div>
		<!-- /.card -->

		</div>
		<!-- /.col-md-6 -->
		*/
		?>

<canvas id="clientChart"></canvas>
<canvas id="dassChart"></canvas>
<canvas id="konselingChart"></canvas>

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