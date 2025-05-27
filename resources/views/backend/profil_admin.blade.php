<!-- Nama Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('nama', 'Nama Lengkap') !!}
    {!! Form::text('nama', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Hp Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('hp', 'Nomor HP (Whatsapp)') !!}
    {!! Form::text('hp', null, ['class' => 'form-control', 'required']) !!}
	<small>Input tanpa angka nol depan. Pastikan nomor HP terintegrasi dengan Whatsapp.</small>
</div>

<div class="col-md-12">
    <hr>
</div>

<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('email', 'e-mail') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'readonly']) !!}
    <small>Pastikan email yang digunakan aktif karena akan digunakan untuk masuk ke dalam sistem</small>
</div>

<!-- Field -->
<div class="form-group col-sm-8 offset-sm-2">
    {!! Form::label('password', 'Password') !!}
	<input class="form-control" type="password" name="password" placeholder="*****">
    <small>Isi password jika ingin mengganti, biarkan jika tidak</small>
</div>

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