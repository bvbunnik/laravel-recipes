@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add a recipe</div>
                    <div class="panel-body">
                        @include('common.errors')
                        <div class="controls">
                            {{ Form::model($recipe, array('action' => 'RecipeController@store', 'class' => 'form-horizontal')) }}
                            {{ Form::bsText('title', $recipe->title) }}

                            {{ Form::bsTextArea('description', $recipe->description, array('rows'=>"5")) }}

                            {{ Form::bsTextArea('preparation', $recipe->preparation, array('rows'=>"10")) }}
                            {{ Form::bsText('photo', $recipe->photo) }}
                            <div class="form-group">
                                {{ Form::label('preview', 'Preview:', array('class' => 'col-sm-2 control-label')) }}
                                <div class="col-sm-8">
                                    <img src="{{$recipe->photo}}">
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('cooking_time', 'Cooking time:', array('class'=>'col-sm-2 control-label')) }}
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" value="{{$recipe->cooking_time}}" name="cooking_time" id="recipe-cooking_time" class="form-control">
                                        <div class="input-group-addon">minutes</div>
                                    </div>
                                </div>

                                <label for="recipe-servings" class="col-sm-1 control-label">Serves:</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" name="servings" value="{{$recipe->servings}}" id="recipe-servings" class="form-control">
                                        <div class="input-group-addon">people</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="recipe-course" class="col-sm-2 control-label">Course:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="course" value="{{$recipe->course->name or ''}}" id="recipe-course" class="form-control">
                                </div>
                                <label for="recipe-cuisine" class="col-sm-1 control-label">Cuisine:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="cuisine" value="{{$recipe->cuisine->name or ''}}" id="recipe-cuisine" class="form-control">
                                </div>
                            </div>

                            @foreach($recipe->ingredients as $ingredient)
                            <div class="form-group">
                                <label for="ingredient" class="col-sm-2 control-label">Ingredient:</label>
                                <div class="col-sm-8">
                                    {{Form::text('ingredient[]', $ingredient, array("class"=>"form-control"))}}
                                </div>
                            </div>
                            @endforeach

                            {{ Form::submit('Save recipe') }}
                            {{ Form::close() }}
                            <script>
                                //CKEDITOR.replace( 'preparation' );
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection