<!-- Steamid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('steamid', 'Steamid:') !!}
    {!! Form::text('steamid', null, ['class' => 'form-control','maxlength' => 64,'maxlength' => 64]) !!}
</div>

<!-- Defid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('defid', 'Defid:') !!}
    {!! Form::number('defid', null, ['class' => 'form-control']) !!}
</div>

<!-- Quality Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quality', 'Quality:') !!}
    {!! Form::number('quality', null, ['class' => 'form-control']) !!}
</div>

<!-- Attributes Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('attributes', 'Attributes:') !!}
    {!! Form::textarea('attributes', null, ['class' => 'form-control']) !!}
</div>

<!-- Hash Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hash', 'Hash:') !!}
    {!! Form::text('hash', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Slot Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slot', 'Slot:') !!}
    {!! Form::number('slot', null, ['class' => 'form-control']) !!}
</div>