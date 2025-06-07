@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<div class="col-sm-10">
	<div class="row">
		<!-- Nama Field -->
		<div class="col-sm-6">
			{!! Form::label('nama', 'Nama') !!}
			<p>{{ $psikolog->nama }}</p>
		</div>

		<!-- Field -->
		<div class="col-sm-6">
			{!! Form::label('sipp', 'SIPP') !!}
			<p>{{ $psikolog->sipp }}</p>
		</div>

		<!-- Field -->
		<div class="col-sm-6">
			{!! Form::label('kta', 'KTA') !!}
			<p>{{ $psikolog->kta }}</p>
		</div>

		<!-- Hp Field -->
		<div class="col-sm-6">
			{!! Form::label('hp', 'HP') !!}
			<p>0{{ $psikolog->hp }}</p>
		</div>

		<!-- Field -->
		<div class="col-sm-6">
			{!! Form::label('alamat_praktek', 'Alamat Praktek') !!}
			<p>{{ $psikolog->alamat_praktek }}</p>
		</div>
	</div>
</div>
<div class="col-sm-2">
	<div class="text-center">
		@if($psikolog->foto)
		<img style="width: 100%;" class="profile-user-img img-fluid img-circle" src="{{asset('storage/uploads/psikolog/'.$psikolog->foto)}}" alt="User profile picture">
		@else
		<img style="width: 100%;" class="profile-user-img img-fluid img-circle" src="https://avataaars.io/?avatarStyle=Circle&topType=LongHairFrida&accessoriesType=Blank&hairColor=Black&facialHairType=Blank&clotheType=BlazerShirt&eyeType=Default&eyebrowType=Default&mouthType=Default&skinColor=Pale" alt="User profile picture">
		@endif
	</div>
</div>

<!-- Updated At Field -->
<!-- <div class="col-sm-12">
	{!! Form::label('updated_at', 'Diupdate') !!}
	<p>{{ $psikolog->updated_at }}</p>
</div> -->
<div class="col-sm-12">
	<hr>
</div>

<div class="col-sm-12">
	<div class="card card-primary card-outline">
		<div class="card-header">
			<h3 class="card-title"><strong>Konseling Klien yang Ditangani Psikolog</strong></h3>
        </div>
		<div class="card-body">
			<div class="table-responsive">

				<table id="example" class='table table-striped table-bordered'>
					<thead>
						<tr>
							<th style="width:10%"></th>
							<th>Registrasi</th>
							<th>Nama Klien</th>
							<th>Jadwal Konseling</th>
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
			"ajax": "{{ route('backend.psikolog-keluhan-json', $psikolog->id) }}",
			"columns": [
				{ data: "aksi", name:"aksi", orderable:false},
				{ data: "created_at", name:"created_at"},
				{ data: "nama", name:"nama"},
				{ data: "tgl_konseling", name:"tgl_konseling"},
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
			order: [[ 4, "desc" ]]
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