<!-- Nama Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('nama', 'Nama Lengkap') !!}
    {!! Form::text('nama', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- jk Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('jk', 'JK:') !!}
    {!! Form::select('jk', ['L' => 'Laki-laki', 'P' => 'Perempuan'], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Hp Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('hp', 'Nomor HP (Whatsapp)') !!}
    {!! Form::text('hp', null, ['class' => 'form-control', 'required']) !!}
	<small>Input tanpa angka nol depan. Pastikan nomor HP terintegrasi dengan Whatsapp.</small>
</div>

<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('nik', 'NIK') !!}
    {!! Form::text('nik', null, ['class' => 'form-control', 'required']) !!}
    <small>Nomor Induk Kependudukan</small>
</div>

<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('kta', 'KTA') !!}
    {!! Form::text('kta', null, ['class' => 'form-control', 'required']) !!}
    <small>Kartu Tanda Anggota</small>
</div>

<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('sipp', 'Nomor SIPP') !!}
    {!! Form::text('sipp', null, ['class' => 'form-control', 'required']) !!}
    <small>Surat Izin Praktik Psikologi</small>
</div>

<!-- Gambar Field -->
<div class="form-group col-sm-4 offset-sm-2">
    {!! Form::label('foto', 'Foto') !!}
    <div class="input-group">
        @if($psikolog && $psikolog->foto)
            <!-- cek apakah file ada di folder -->
            @if(file_exists(storage_path('app/public/uploads/psikolog/'.$psikolog->foto)))
                <img class="img-fluid col-12" src="{{asset('storage/uploads/psikolog/'.$psikolog->foto)}}" style="height:20%">
            @else
                <img class="img-fluid col-12" src="{{asset('img/pp_user.jpg')}}" style="height:20%">
            @endif
        @endif
        <div class="col-12 custom-file" style="margin-top: 15px;">
            {!! Form::file('foto', ['class' => 'custom-file-input']) !!}
            {!! Form::label('foto', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>

<!-- Gambar Field -->
<div class="form-group col-sm-4">
    {!! Form::label('ttd', 'TTD') !!}
    <div class="input-group">
        @if($psikolog && $psikolog->ttd)
            <!-- cek apakah file ada di folder -->
            @if(file_exists(storage_path('app/public/uploads/psikolog/'.$psikolog->ttd)))
                <img class="img-fluid col-12" src="{{asset('storage/uploads/psikolog/'.$psikolog->ttd)}}" style="height:20%">
            @else
                <img class="img-fluid col-12" src="{{asset('img/pp_user.jpg')}}" style="height:20%">
            @endif
        @endif
        <div class="col-12 custom-file" style="margin-top: 15px;">
            {!! Form::file('ttd', ['class' => 'custom-file-input']) !!}
            {!! Form::label('ttd', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="col-md-12">
    <hr>
</div>

<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('alamat_rumah', 'Alamat Rumah') !!}
    {!! Form::textarea('alamat_rumah', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="col-md-12">
    <hr>
</div>

@if(!Route::is('psikologs.edit') )

<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('alamat_praktek', 'Alamat Praktek') !!}
    {!! Form::textarea('alamat_praktek', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('kec_id', 'Kecamatan Alamat Praktek') !!}
    <select name="kec_id" id="kec_id" class="form-control" required="">
        <option value="">Pilih</option>
    </select>
</div>

<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('desa_id', 'Desa Alamat Praktek') !!}
    <select name="desa_id" id="desa_id" class="form-control" required="">
        <option value="">Pilih</option>
    </select>
</div>
@else

<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('alamat_praktek', 'Alamat Praktek') !!}
    {!! Form::textarea('alamat_praktek', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group col-sm-8 offset-sm-2">
	{!! Form::label('kec_id', 'Kecamatan Alamat Praktek') !!}
	<input type="text" class="form-control" value="{{ App\Http\Controllers\PsikologController::kec($psikolog->kec_id) }}" readonly>
</div>
<div class="form-group col-sm-8 offset-sm-2">
	{!! Form::label('kec_id', 'Desa Alamat Praktek') !!}
	<input type="text" class="form-control" value="{{ App\Http\Controllers\PsikologController::desa($psikolog->desa_id) }}" readonly>
</div>
@endif

<div class="col-md-12">
    <hr>
</div>

<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('email', 'e-mail') !!}
	@if(Route::is('psikologs.edit'))
    {!! Form::text('email', null, ['class' => 'form-control', 'readonly']) !!}
	@else
	{!! Form::text('email', null, ['class' => 'form-control', 'required']) !!}
	@endif
    <small>Pastikan email yang digunakan aktif karena akan digunakan untuk masuk ke dalam sistem</small>
</div>

@if(Route::is('psikologs.edit') )
<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('password', 'Password') !!}
	<input class="form-control" type="password" name="password" placeholder="*****">
    <small>Isi password jika ingin mengganti, biarkan jika tidak</small>
</div>
@endif

<div class="col-md-12">
    <hr>
</div>

@if(Route::is('psikologs.edit'))
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('status', 'Status User') !!}
    <select name="status" id="status" class="form-control" required="">
        <option value="">Pilih</option>
		<option value="1" @if($psikolog->status==1) {{ "selected" }} @endif>Aktif</option>
		<option value="0" @if($psikolog->status==0) {{ "selected" }} @endif>Tidak Aktif</option>
    </select>
	<small>Jika user tidak aktif, user tidak dapat masuk ke dalam sistem.</small>
</div>
@endif

<!-- User Id Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div> -->

@push('page_scripts')

<script type="text/javascript">
	const fetchAllTodos = () => {
	return fetch("//www.emsifa.com/api-wilayah-indonesia/api/districts/5171.json")
		.then((response) => {
			if (!response.ok) {
				throw new Error('Network response was not ok.');
			}
			return response.json();
		})
		.then((data) => {
			console.log(data);
			return data;
		})
		.catch((error) => {
			return error;
		});
	};

	// Ambil tag id container
	const containerDisplay = document.getElementById('kec_id')

	// Komponen Card untuk render semua data
	const cardComponent = (id, title) => {
		// Buat Card
		const data = `
			<option value="${id}">${title}</option>
		`
		// Tambahkan kedalam elemen container yang sudah kita definisikan sebelumnya
		containerDisplay.insertAdjacentHTML('afterbegin', data)
	}

	function render() {
		fetchAllTodos()
			.then((response) => {
				response.forEach(result => {
					cardComponent(result.id, result.name);
				});
			})
			.catch((error) => {
				console.error('Error rendering data:', error);
			});
	}

	render();

	document.querySelector('#kec_id').addEventListener('change', function() {
		const opsi = document.querySelector('#kec_id').value;

		const url = `//www.emsifa.com/api-wilayah-indonesia/api/villages/${opsi}.json`;

		fetch(url)
			.then((response) => {
				if (!response.ok) {
					throw new Error('Network response was not ok.');
				}
				return response.json();
			})
			.then((data) => {
				console.log(data);
				const containerDisplay = document.getElementById('desa_id');
				containerDisplay.innerHTML = "<option value=''>Pilih</option>";
				data.forEach(result => {
					const data = `
						<option value="${result.id}">${result.name}</option>
					`
					containerDisplay.insertAdjacentHTML('afterbegin', data)
				});
			})
			.catch((error) => {
				return error;
			});
	});
</script>
@endpush