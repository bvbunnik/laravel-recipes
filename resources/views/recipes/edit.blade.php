@extends('layouts.app')

@section('content')
    <div class="recipe">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card card-inverse">
                    <div class="card-header card-primary">Add a recipe</div>
                    <div class="card-block">
                    @include('common.errors')
                        <div class="controls">
                            <?php echo Form::model($recipe, ['route' => ['recipes.update', $recipe->id]]) ?>
                               <div class="form-group row">
							   		<label for="recipe-title" class="col-sm-2 col-form-label">Title:</label>
                                    <div class="col-sm-10">
										{{ Form::text('title', null, ['class' => ($errors->has('title')) ? 'form-control is-invalid' : 'form-control']) }}
									</div>
                                </div>
                                <div class="form-group row">
                                    <label for="recipe-description" class="col-sm-2 col-form-label">Description:</label>
                                    <div class="col-sm-10">
										{{ Form::textarea('description', null, ['class' => ($errors->has('title')) ? 'form-control is-invalid' : 'form-control', 'id' => 'recipe-description']) }}
                                        <!--<textarea rows="5" name="description" id="recipe-description" class="form-control"></textarea>-->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="recipe-preparation" class="col-sm-2 col-form-label">Preparation:</label>
                                    <div class="col-sm-10">
                                        {{ Form::textarea('preparation', null, ['rows'=>'10', 'class' => ($errors->has('title')) ? 'form-control is-invalid' : 'form-control', 'id' => 'recipe-preparation']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="recipe-photo" class="col-sm-2 col-form-label">Upload photo-file:</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="photo" id="recipe-photo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="recipe-photo-url" class="col-sm-2 col-form-label">Link to photo:</label>
                                    <div class="col-sm-10">
                                        {{ Form::text('photo-url', null, ['class' => ($errors->has('photo-url')) ? 'form-control is-invalid' : 'form-control', 'id' => 'recipe-photo-url']) }}
                                        <!--<input type="text" name="photo_url" id="recipe-photo-url" class="form-control">-->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="recipe-cooking_time" class="col-sm-2 col-form-label">Cooking time:</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            {{ Form::text('cooking_time', null, ['id'=>'recipe-cooking_time', 'class' => ($errors->has('cooking_time')) ? 'form-control is-invalid' : 'form-control']) }}
                                            <div class="input-group-addon">minutes</div>
                                        </div>
                                    </div>

                                    <label for="recipe-servings" class="col-sm-1 col-form-label">Serves:</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            {{ Form::text('servings', null, ['id'=>'recipe-servings','class' => ($errors->has('servings')) ? 'form-control is-invalid' : 'form-control']) }}
                                            <div class="input-group-addon">people</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="recipe-course" class="col-sm-2 col-form-label">Course:</label>
                                    <div class="col-sm-2">
                                        {{ Form::text('course', null, ['id'=>'recipe-course', 'class' => ($errors->has('course')) ? 'form-control is-invalid' : 'form-control']) }}
                                        <input type="text" name="course" id="recipe-course" class="form-control">
                                    </div>
                                    <label for="recipe-cuisine" class="col-sm-1 col-form-label">Cuisine:</label>
                                    <div class="col-sm-2">
                                        {{ Form::text('cuisine', null, ['id'=>'recipe-cuisine', 'class' => ($errors->has('cuisine')) ? 'form-control is-invalid' : 'form-control']) }}
                                        <input type="text" name="cuisine" id="recipe-cuisine" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row entry">
                                    <label for="recipe-quantity" class="col-sm-2 col-form-label">Ingredient:</label>
                                    <div class="col-sm-3">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" name="quantity[]" placeholder="Quantity" id="recipe-quantity" class="form-control">
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="text" name="unit[]" placeholder="Unit" class="form-control recipe-unit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="text" name="ingredient[]" class="recipe-ingredient form-control">
                                            <span class="input-group-btn">
                                                    <button class="btn btn-success btn-add" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-plus"></i> Add Recipe
                                        </button>
                                    </div>
                                </div>
                                <script>
                                    CKEDITOR.replace( 'preparation' );
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('after-script')
    <script>
        $(function() {
            var availableTags = {!! $courses_list !!};
            $( "#recipe-course" ).autocomplete({
                source: availableTags
            });
        });
        $(function() {
            var availableTags = {!! $cuisines_list !!};
            $( "#recipe-cuisine" ).autocomplete({
                source: availableTags
            });
        });
        $(function() {
            var availableTags = {!! $units_list !!};
            $( ".recipe-unit" ).autocomplete({
                source: availableTags
            });
        });
        $(function() {
            var availableTags = {!! $ingredients_list !!};
            $( ".recipe-ingredient" ).autocomplete({
                source: availableTags
            });
        });

        $(function()
        {
            $(document).on('click', '.btn-add', function(e)
            {
                e.preventDefault();

                var controlForm = $('.controls form:first'),
                        currentEntry = $(this).parents('.entry:first'),
                        newEntry = $(currentEntry.clone()).insertAfter(currentEntry);

                newEntry.find('input').val('');
                controlForm.find('.entry:not(:last) .btn-add')
                        .removeClass('btn-add').addClass('btn-remove')
                        .removeClass('btn-success').addClass('btn-danger')
                        .html('<span class="fa fa-minus"></span>');
                var availableTags = {!! $ingredients_list !!};
                controlForm.find(".recipe-ingredient").autocomplete({
                   source: availableTags
                });
                var availableTags = {!! $units_list !!};
                controlForm.find(".recipe-unit").autocomplete({
                    source: availableTags
                });

            }).on('click', '.btn-remove', function(e)
            {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });
        });
        {{--$(function() {--}}
            {{--var availableTags = {!! $ingredients_list !!};--}}
            {{--$( '#recipe-ingredient:last' ).autocomplete({--}}
                    {{--source: availableTags--}}
                {{--});--}}
            {{--});--}}
    </script>
@endsection
