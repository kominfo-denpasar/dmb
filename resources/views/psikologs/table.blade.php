@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<div class="card card-primary card-outline">
	<div class="card-body">
		<div class="table-responsive">

			<table id="example" class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th style="width:10%"></th>
						<th>Nama</th>
						<th>Kontak</th>
						<th>Kecamatan Praktek</th>
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
	<div class="card-footer">
		<div class="mailbox-controls">
			
			<div class="float-right">
				<!-- @include('adminlte-templates::common.paginate', ['records' => $psikologs]) -->
			</div>
			<!-- /.float-right -->
		</div>
	</div>
</div>
<!-- /.card -->

@push('third_party_scripts')

	@include('layouts.datatables_js')
	<script>
		let selectedKec = '';
		var tb = $('#example').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "{{ route('backend.psikolog-json') }}",
				"data": function(d) {
					d.status = '{{ request("status") }}';
					d.kec_id = selectedKec;
				}
			},
			"columns": [
				{ data: "aksi", name:"aksi", orderable:false},
				{ data: "nama", name:"nama"},
				{ data: "hp", name:"hp"},
				{ data: "kec_id", name:"kec_id"},
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

		$('#wilayah_filter a').on('click', function(e) {
			e.preventDefault();
			selectedKec = $(this).data('kec');  // update variabel global
			$('#wilayah_filter a').removeClass('active');
			$(this).addClass('active');
			tb.ajax.reload();  // reload datatable dengan filter baru
		});
	</script>
@endpush