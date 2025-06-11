<!-- Helper Field -->
<div class="form-group col-sm-12">
    {!! Form::label('helper', 'Informasi:') !!}
    <p>{{ $pengaturan->helper }}</p>
</div>

<!-- Value Field -->
<div class="form-group col-sm-12">
@if($pengaturan->value_type=="textarea")
    {!! Form::label('value', 'Value:') !!}
    {!! Form::textarea('value', null, ['class' => 'form-control']) !!}
@elseif($pengaturan->value_type=="number")
    {!! Form::label('value', 'Value:') !!}
    {!! Form::number('value', null, ['class' => 'form-control']) !!}
@else
    {!! Form::label('value', 'Value:') !!}
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
@endif
</div>

<!-- Slug Field -->
<div class="form-group col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control', 'readonly']) !!}
</div>



<!-- Value Type Field -->
<!-- <div class="form-group col-sm-12">
    {!! Form::label('value_type', 'Value Type:') !!}
    {!! Form::text('value_type', null, ['class' => 'form-control']) !!}
</div> -->

<!-- User Id Field -->
<!-- <div class="form-group col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div> -->

<!-- tinymce -->
<script src="https://cdn.tiny.cloud/1/c6odapdaj480ujk53w7tjrzh8nh78qpep4hucsg70oi0ze5n/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        height: 500,
        menubar: false,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });
</script>
