<!-- Title Field -->
<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Detail Field -->
<div class="form-group col-sm-12">
    {!! Form::label('detail', 'Detail:') !!}
    {!! Form::text('detail', null, ['class' => 'form-control']) !!}
</div>

<!-- Findme Field -->
<div class="form-group col-sm-12">
    {!! Form::label('findme', 'Findme:') !!}
    {!! Form::text('findme', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Start Field -->
<div class="form-group col-sm-12">
    {!! Form::label('date_start', 'Date Start:') !!}
    {!! Form::date('date_start', null, ['class' => 'form-control']) !!}
</div>

<!-- Every Field -->
<div class="form-group col-sm-12">
    {!! Form::label('every', 'Every:') !!}
    {!! Form::text('every', null, ['class' => 'form-control']) !!}
</div>

<!-- Checked Field -->
<div class="form-group col-sm-6">
    {!! Form::label('checked', 'Checked:') !!}
    <label class="checkbox-inline">
        {!! Form::checkbox('checked', '1') !!} 
    </label>
</div>

<!-- Last Reboot Field -->
<div class="form-group col-sm-12">
    {!! Form::label('last_reboot', 'Last Reboot:') !!}
    {!! Form::date('last_reboot', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Delta Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount_delta', 'Amount Delta:') !!}
    {!! Form::number('amount_delta', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12 text-center">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.operationRecurents.index') !!}" class="btn btn-default">Cancel</a>
</div>
