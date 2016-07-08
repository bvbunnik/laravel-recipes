@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>{{$recipe->title}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="wrapper" style="background-image: url('{!! url($recipe->photo) !!}'); background-size: 100%; background-repeat: no-repeat; height:300px;">
                    <div class="info-div">
                        <ul class="info-list">
                            <li><i class="fa fa-briefcase" aria-hidden="true"></i> {!! $recipe->course->name !!}</li>
                            <li><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {!! $recipe->servings !!} persons</li>
                            <li><span class="glyphicon glyphicon-time" aria-hidden="true"></span> {!! $recipe->cooking_time !!} minutes</li>
                            <li><span class="glyphicon glyphicon-flag" aria-hidden="true"></span> {!! $recipe->cuisine->name !!}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="well well-lg">
                    {!! $recipe->description !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <h3>Ingredients:</h3>
                <ul>
                    @foreach($recipe->ingredients as $ingredient)
                        <li>{!! $ingredient->pivot->quantity !!} {!! $ingredient->units_title !!} {!! $ingredient->name !!}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Preparation:</h3>
                {!! $recipe->preparation !!}
            </div>
        </div>

    </div>
@endsection