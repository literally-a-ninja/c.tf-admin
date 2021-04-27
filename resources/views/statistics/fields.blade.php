<!-- Target Field -->
<div class="form-group col-sm-6">
    {!! Form::label('target', 'Target:') !!}
    {!! Form::text('target', null, ['class' => 'form-control','maxlength' => 150,'maxlength' => 150]) !!}
</div>

<!-- Progress Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('progress', 'Progress:') !!}
    {!! Form::textarea('progress', null, ['class' => 'form-control']) !!}
</div>