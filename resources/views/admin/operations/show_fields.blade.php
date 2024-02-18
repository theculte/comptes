<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $operation->id !!}</p>
    <hr>
</div>

<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{!! $operation->date !!}</p>
    <hr>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $operation->title !!}</p>
    <hr>
</div>

<!-- Detail Field -->
<div class="form-group">
    {!! Form::label('detail', 'Detail:') !!}
    <p>{!! $operation->detail !!}</p>
    <hr>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{!! $operation->amount !!}</p>
    <hr>
</div>

<!-- Currency Field -->
<div class="form-group">
    {!! Form::label('currency', 'Currency:') !!}
    <p>{!! $operation->currency !!}</p>
    <hr>
</div>

<!-- Checked Field -->
<div class="form-group">
    {!! Form::label('checked', 'Checked:') !!}
    <p>@if( $operation->checked  =='1') true @else false @endif</p>
    <hr>
</div>

