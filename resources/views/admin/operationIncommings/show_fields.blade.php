<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $operationIncomming->id !!}</p>
    <hr>
</div>

<!-- Id Operation Type Field -->
<div class="form-group">
    {!! Form::label('id_operation_type', 'Id Operation Type:') !!}
    <p>{!! $operationIncomming->id_operation_type !!}</p>
    <hr>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{!! $operationIncomming->amount !!}</p>
    <hr>
</div>

<!-- Amount Delta Field -->
<div class="form-group">
    {!! Form::label('amount_delta', 'Amount Delta:') !!}
    <p>{!! $operationIncomming->amount_delta !!}</p>
    <hr>
</div>

