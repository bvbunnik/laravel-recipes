@extends('layouts.app')

@section('content')
    <div class="recipe">
        <div class="container-fluid">
            @foreach(array_chunk($recipes->all(),2) as $recipesRow)
            <div class="row">
                @foreach($recipesRow as $recipe)
                <div class="col-lg-5 offset-lg-1">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">{{ $recipe->title }}</h4>
                            <h6 class="card-subtitle text-muted">{!! $recipe->description !!}</h6>
                        </div>
                        <img class="card-img" src="{{url($recipe->photo)}}" alt="Card image" class="card-img">
                        <div class="card-block">
                            <p class="card-text">{!! str_limit($recipe->preparation,100) !!}</p>
                            <a href="/recipes/{{$recipe->id}}/" class="btn btn-primary">View Recipe</a>
                        </div>
                        <div class="card-footer text-muted">
                            <a href="#" class="pull-lg-right">Add to favourites</a>
                            <div class="pull-lg-left">Last prepared: 2 days ago</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
@endsection