<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $category->id !!}</p>
    <hr>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $category->name !!}</p>
    <hr>
</div>

<!-- Id Parent Field -->
<div class="form-group">
    {!! Form::label('id_parent', 'Id Parent:') !!}
    <p>{!! $category->id_parent !!}</p>
    <hr>
</div>

<!-- Findme Field -->
<div class="form-group">
    {!! Form::label('color', 'Color:') !!}
    <p>{!! $category->color !!}</p>
    <hr>
</div>

<!-- Icon Field -->
<div class="form-group">
    {!! Form::label('icon', 'Icon:') !!}
    <p>{!! $category->icon !!}</p>
    <hr>
</div>

