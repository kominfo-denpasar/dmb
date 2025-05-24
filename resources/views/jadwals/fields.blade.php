<!-- Tgl Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Hari', 'Hari:') !!}
    {!! Form::select('hari', ['' => '- Pilih -', 'Senin' => 'Senin', 'Selasa' => 'Selasa', 'Rabu' => 'Rabu', 'Kamis' => 'Kamis', 'Jumat' => 'Jumat', 'Sabtu' => 'Sabtu', 'Minggu' => 'Minggu'], null, ['class' => 'form-control', 'required']) !!}
    <small>Pilih salah satu hari</small>
</div>

@push('page_scripts')
<!-- <script type="module">        
    $(document).ready(function() {
        $('#tgl').datepicker()
    })
</script> -->
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="//code.jquery.com/jquery-3.6.0.js"></script>
<script src="//code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script type="text/javascript">
    $('#tgl').datepicker()
</script> -->
@endpush

<!-- Jam Field -->
<div class="form-group col-sm-6">
    {!! Form::label('jam', 'Jam') !!}
    {!! Form::text('jam', null, ['class' => 'form-control', 'required', 'placeholder' => 'xx:xx - xx:xx']) !!}
    <small>Inputkan rentang jam praktek Anda dalam format waktu 24 jam. (Misal: 10:00 - 13:00). Jam Praktek yang lebih dari satu dapat dipisahkan dengan tanda koma.</small>
</div>

<!-- Kuota Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('kuota', 'Kuota:') !!}
    {!! Form::number('kuota', null, ['class' => 'form-control', 'required']) !!}
</div> -->

<!-- Psikolog Id Field -->
<input type="hidden" name="psikolog_id" value="{{ $user->psikolog_id }}">