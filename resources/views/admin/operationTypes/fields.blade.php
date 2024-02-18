<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Category Field -->
<div class="form-group col-sm-12">
    {!! Form::label('id_category', 'Id Category:') !!}
    {!! Form::number('id_category', null, ['class' => 'form-control']) !!}
</div>

<!-- Findme Field -->
<div class="form-group col-sm-12">
    {!! Form::label('findme', 'Findme:') !!}
    {!! Form::text('findme', null, ['class' => 'form-control']) !!}
</div>

<!-- Icon Field -->
<div class="form-group col-sm-12">
    {!! Form::label('icon', 'Icon:') !!}
    {!! Form::text('icon', null, ['class' => 'form-control']) !!}
</div>

<!-- Tags Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tags', 'Tags:') !!}
    {!! Form::text('tags', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12 text-center">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.operationTypes.index') !!}" class="btn btn-default">Cancel</a>
</div>
