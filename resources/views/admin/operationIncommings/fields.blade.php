<!-- Id Operation Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('id_operation_type', 'Id Operation Type:') !!}
    {!! Form::number('id_operation_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Delta Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount_delta', 'Amount Delta:') !!}
    {!! Form::number('amount_delta', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12 text-center">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.operationIncommings.index') !!}" class="btn btn-default">Cancel</a>
</div>
