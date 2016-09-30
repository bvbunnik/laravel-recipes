@extends('layouts.app')

@section('content')
    <div class="recipe">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                <div class="card card-inverse">
                    <div class="card-header  card-primary">Import recipe</div>
                    <div class="card-block">
                        @include('common.errors')
                        <div class="controls">
                            {{ Form::model($recipe, array('action' => 'RecipeController@store', 'class' => 'form-horizontal')) }}
                            {{ Form::bsText('title', $recipe->title) }}

                            {{ Form::bsTextArea('description', $recipe->description, array('rows'=>"5")) }}

                            {{ Form::bsTextArea('preparation', $recipe->preparation, array('rows'=>"10")) }}
                            {{ Form::bsText('photo_url', $recipe->photo) }}
                            <div class="form-group row">
                                {{ Form::label('preview', 'Preview:', array('class' => 'col-sm-2 col-form-label')) }}
                                <div class="col-sm-10">
                                    <img src="{{$recipe->photo_url}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('cooking_time', 'Cooking time:', array('class'=>'col-sm-2 col-form-label')) }}
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" value="{{$recipe->cooking_time}}" name="cooking_time" id="recipe-cooking_time" class="form-control">
                                        <div class="input-group-addon">minutes</div>
                                    </div>
                                </div>

                                <label for="recipe-servings" class="col-sm-1 col-form-label">Serves:</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" name="servings" value="{{$recipe->servings}}" id="recipe-servings" class="form-control">
                                        <div class="input-group-addon">people</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="recipe-course" class="col-sm-2 col-form-label">Course:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="course" value="{{$recipe->course->name or ''}}" id="recipe-course" class="form-control">
                                </div>
                                <label for="recipe-cuisine" class="col-sm-1 col-form-label">Cuisine:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="cuisine" value="{{$recipe->cuisine->name or ''}}" id="recipe-cuisine" class="form-control">
                                </div>
                            </div>
                            <?php
                                $descr=$recipe->ingredients->all()['descr'];
                                $quantity=$recipe->ingredients->all()['quantity'];
                                $unit=$recipe->ingredients->all()['unit'];
                            ?>
                            @for($i=0; $i<count($descr); ++$i)
                                <div class="form-group row">
                                <label for="recipe-quantity" class="col-sm-2 col-form-label">Ingredient:</label>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" name="quantity[]" value="{{$quantity[$i] or ''}}" placeholder="Quantity" id="recipe-quantity" class="form-control">
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" name="unit[]" value="{{$unit[$i] or ''}}" placeholder="Unit" class="form-control recipe-unit">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" name="ingredient[]" value="{{$descr[$i] or ''}}" class="recipe-ingredient form-control">
                                    </div>
                                </div>
                            </div>
                            @endfor

                            <div class="form-group row">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-plus"></i> Save Recipe
                                    </button>
                                </div>
                            </div>
                            {{ Form::close() }}
                            <script>
                                CKEDITOR.replace( 'preparation' );
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection