@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<div class="col-sm-10">
	<div class="row">
		<!-- Nama Field -->
		<div class="col-sm-4 mb-3">
			{!! Form::label('nama', 'Nama:') !!}
            <p>{{ $masyarakat->nama }}</p>
		</div>

		<!-- nik Field -->
		<div class="col-sm-4 mb-3">
			{!! Form::label('nik', 'Nik:') !!}
            <p>{{ $masyarakat->nik }}</p>
		</div>

		<!-- tgl lahir Field -->
		<div class="col-sm-4 mb-3">
			{!! Form::label('tgl_lahir', 'Tgl Lahir:') !!}
            <p>{{ $masyarakat->tgl_lahir }}</p>
		</div>

		<!-- Hp Field -->
		<div class="col-sm-4 mb-3">
			{!! Form::label('hp', 'Hp:') !!}
            <p>{{ $masyarakat->hp }}</p>
		</div>

		<!-- alamat Field -->
		<div class="col-sm-4 mb-3">
			{!! Form::label('alamat', 'Alamat:') !!}
            <p>{{ $masyarakat->alamat }}</p>
		</div>

        <!-- desa Field -->
        <div class="col-sm-4 mb-3">
			{!! Form::label('desa_id', 'Desa:') !!}
    		<p>{{ \App\Http\Controllers\PsikologController::desa($masyarakat->desa_id) }}</p>
		</div>

        <!-- kecamaatan Field -->
        <div class="col-sm-4 mb-3">
			{!! Form::label('kec_id', 'Kecamatan:') !!}
			<p>{{ \App\Http\Controllers\PsikologController::kec($masyarakat->kec_id) }}</p>
		</div>

        <!-- user id Field -->
        {{-- <div class="col-sm-4 mb-3">
			{!! Form::label('user_id', 'User Id:') !!}
            <p>{{ $masyarakat->user_id }}</p>
		</div> --}}

        <!-- create user Field -->
        <div class="col-sm-4 mb-3">
			{!! Form::label('created_at', 'Created At:') !!}
            <p>{{ $masyarakat->created_at }}</p>
		</div>

        <!-- update user Field -->
        <div class="col-sm-4 mb-3">
			{!! Form::label('updated_at', 'Updated At:') !!}
            <p>{{ $masyarakat->updated_at }}</p>
		</div>

	</div>
</div>

<div class="col-sm-12">
	<hr>
</div>

<div class="col-sm-12">
	<div class="card card-primary card-outline">
		<div class="card-header">
			<h3 class="card-title"><strong>Riwayat Konseling Masyarakat/Client Details</strong></h3>
        </div>
		<div class="card-body">
			<div class="table-responsive">

				<table id="example" class='table table-striped table-bordered'>
					<thead>
						<tr>
							<th style="width:10%"></th>
							<th>Tanggal Registrasi</th>
							<th>Nama Konselor</th>
							<th>Hasil</th>
							<th>Kesimpulan</th>
							<th>Saran</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				<!-- /.table -->
			</div>
			<!-- /.table-responsive -->
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div> 



@push('third_party_scripts')

	@include('layouts.datatables_js')
	<script>
		var tb = $('#example').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "{{ route('backend.masyarakat-json', $masyarakat->token) }}",
			// "ajax": "{{ route('backend.masyarakat-json', $masyarakat->token) }}"
			"columns": [
				{ data: "aksi", name:"aksi", orderable:false},
				// { data: "created_at", name:"created_at"},
				{ data: "keluhan_id", name:"keluhan_id"},
				{ data: "nama", name:"nama"},
				{ data: "hasil", name:"hasil"},
				{ data: "kesimpulan", name:"kesimpulan"},
				{ data: "saran", name:"saran"},
				{ data: "status", name:"status"},
			],
			"language": {
				"lengthMenu": "Tampilkan _MENU_ Data per Halaman",
				"zeroRecords": "Tidak ada Data",
				"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ total data",
				"infoEmpty": "Tabel kosong",
				"infoFiltered": "(Difilter dari _MAX_ total data)",
				"search": "Pencarian",
				"paginate": {
					"first":      "Pertama",
					"last":       "Terakhir",
					"next":       ">",
					"previous":   "<"
				},
			},
			columnDefs: [{
				"orderable": true,
				"defaultContent": "-", "targets": "_all",
				"targets"  : 'no-sort',
			}],
			//"dom": "ltrip",
			order: [[ 3, "desc" ]]
		});
		// pencarian
		$('#status_filter').on('change', function(){
			var searchText2;
			if($(this).val()=='') {
				searchText2 = '';
			} else {
				//searchText2 = '^' + $(this).val() + '$';
				searchText2 = $(this).val();
			}
			tb.column(1).search(searchText2, true, false, true).draw();   
		});
	</script>
@endpush 
