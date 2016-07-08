@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Available Recipes</div>
                    <div class="panel-body">
                        <ul>
                            @foreach($recipes as $recipe)
                                <li><a href="/recipes/{{$recipe->id}}/">{{ $recipe->title }}</a></li>
                            @endforeach
                        </ul>
                        <a href="/recipes/create/">Add a recipe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection