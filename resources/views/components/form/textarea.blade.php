<div class="form-group">
    {{ Form::label($name, null, ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-8">
        {{ Form::textarea($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
    </div>
</div>