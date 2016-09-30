<div class="form-group row">
    {{ Form::label($name, null, ['class' => 'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::textarea($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
    </div>
</div>