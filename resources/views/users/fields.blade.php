<!-- Steamid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('steamid', 'Steamid:') !!}
    {!! Form::text('steamid', null, ['class' => 'form-control','maxlength' => 18,'maxlength' => 18]) !!}
</div>

<!-- Alias Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alias', 'Alias:') !!}
    {!! Form::text('alias', null, ['class' => 'form-control','maxlength' => 32,'maxlength' => 32]) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 256,'maxlength' => 256]) !!}
</div>

<!-- Motd Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('motd', 'Motd:') !!}
    {!! Form::textarea('motd', null, ['class' => 'form-control']) !!}
</div>

<!-- Avatar Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('avatar', 'Avatar:') !!}
    {!! Form::textarea('avatar', null, ['class' => 'form-control']) !!}
</div>

<!-- Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('token', 'Token:') !!}
    {!! Form::text('token', null, ['class' => 'form-control','maxlength' => 512,'maxlength' => 512]) !!}
</div>

<!-- Bans Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bans', 'Bans:') !!}
    {!! Form::number('bans', null, ['class' => 'form-control']) !!}
</div>

<!-- Special Field -->
<div class="form-group col-sm-6">
    {!! Form::label('special', 'Special:') !!}
    {!! Form::number('special', null, ['class' => 'form-control']) !!}
</div>

<!-- Admin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('admin', 'Admin:') !!}
    {!! Form::number('admin', null, ['class' => 'form-control']) !!}
</div>

<!-- Connections Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('connections', 'Connections:') !!}
    {!! Form::textarea('connections', null, ['class' => 'form-control']) !!}
</div>

<!-- Loadout Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('loadout', 'Loadout:') !!}
    {!! Form::textarea('loadout', null, ['class' => 'form-control']) !!}
</div>

<!-- Settings Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('settings', 'Settings:') !!}
    {!! Form::textarea('settings', null, ['class' => 'form-control']) !!}
</div>

<!-- Queried Field -->
<div class="form-group col-sm-6">
    {!! Form::label('queried', 'Queried:') !!}
    {!! Form::number('queried', null, ['class' => 'form-control']) !!}
</div>

<!-- Exp Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exp', 'Exp:') !!}
    {!! Form::number('exp', null, ['class' => 'form-control']) !!}
</div>

<!-- Credit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('credit', 'Credit:') !!}
    {!! Form::number('credit', null, ['class' => 'form-control']) !!}
</div>

<!-- Contract Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contract', 'Contract:') !!}
    {!! Form::number('contract', null, ['class' => 'form-control']) !!}
</div>

<!-- Owner Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('owner', 'Owner:') !!}
    {!! Form::textarea('owner', null, ['class' => 'form-control']) !!}
</div>

<!-- Lastlogin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lastlogin', 'Lastlogin:') !!}
    {!! Form::text('lastlogin', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Lastserver Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lastserver', 'Lastserver:') !!}
    {!! Form::text('lastserver', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Backpack Pages Field -->
<div class="form-group col-sm-6">
    {!! Form::label('backpack_pages', 'Backpack Pages:') !!}
    {!! Form::number('backpack_pages', null, ['class' => 'form-control']) !!}
</div>

<!-- Presence Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('presence', 'Presence:') !!}
    {!! Form::textarea('presence', null, ['class' => 'form-control']) !!}
</div>