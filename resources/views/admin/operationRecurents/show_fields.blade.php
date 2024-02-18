<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $operationRecurent->id !!}</p>
    <hr>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $operationRecurent->title !!}</p>
    <hr>
</div>

<!-- Detail Field -->
<div class="form-group">
    {!! Form::label('detail', 'Detail:') !!}
    <p>{!! $operationRecurent->detail !!}</p>
    <hr>
</div>

<!-- Findme Field -->
<div class="form-group">
    {!! Form::label('findme', 'Findme:') !!}
    <p>{!! $operationRecurent->findme !!}</p>
    <hr>
</div>

<!-- Date Start Field -->
<div class="form-group">
    {!! Form::label('date_start', 'Date Start:') !!}
    <p>{!! $operationRecurent->date_start !!}</p>
    <hr>
</div>

<!-- Every Field -->
<div class="form-group">
    {!! Form::label('every', 'Every:') !!}
    <p>{!! $operationRecurent->every !!}</p>
    <hr>
</div>

<!-- Checked Field -->
<div class="form-group">
    {!! Form::label('checked', 'Checked:') !!}
    <p>@if( $operationRecurent->checked  =='1') true @else false @endif</p>
    <hr>
</div>

<!-- Last Reboot Field -->
<div class="form-group">
    {!! Form::label('last_reboot', 'Last Reboot:') !!}
    <p>{!! $operationRecurent->last_reboot !!}</p>
    <hr>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{!! $operationRecurent->amount !!}</p>
    <hr>
</div>

<!-- Amount Delta Field -->
<div class="form-group">
    {!! Form::label('amount_delta', 'Amount Delta:') !!}
    <p>{!! $operationRecurent->amount_delta !!}</p>
    <hr>
</div>

