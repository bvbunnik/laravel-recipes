@extends('layouts.app')

@section('content')
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                ...
            </div>
        </div>
    </div>
    <div class="recipe">
        <div class="container">
            <div class="row">
                <div class="col-md-12 p-b-1">
                    <h1 class="display-4">{{$recipe->title}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="wrapper" style="background-image: url('{!! url($recipe->photo) !!}'); background-position: center; background-size: 100%; background-repeat: no-repeat; height:300px;">
                        <div class="info-div">
                            <ul class="info-list">
                                <li><div class="icon icon-course" aria-hidden="true"></div> {!! $recipe->course->name !!}</li>
                                <li><span class="fa fa-user" aria-hidden="true"></span> {!! $recipe->servings !!} persons</li>
                                <li><span class="fa fa-clock-o" aria-hidden="true"></span> {!! $recipe->cooking_time !!} minutes</li>
                                <li><span class="fa fa-flag" aria-hidden="true"></span> {!! $recipe->cuisine->name !!}</li>
                                <li>Rating: <input type="hidden" class="rating" data-fractions="2" value="{{$recipe->rating}}">
                                    <div class="rating-success" style="display: none;">Saved your rating!</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-t-1">
                <div class="col-md-12 ">
                    <div class="card card-block bg-faded">
                        {!! $recipe->description !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h3>Ingredients:</h3>
                    <ul class="ingredients-list">
                        @foreach($recipe->ingredients as $ingredient)
                            <li>{!! $ingredient->pivot->quantity !!} {!! $ingredient->units_title !!} {!! $ingredient->name !!}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>Preparation:</h3>
                    {!! $recipe->preparation !!}
                </div>
            </div>

        </div>
    </div>
@endsection

@section('after-script')
    <script type="text/javascript" src="/js/bootstrap-rating.js"></script>
    <script>


        $('.rating').rating({
            filled: 'fa fa-star custom-star',
            empty: 'fa fa-star-o custom-star'
        });

        $('.rating').on('change', function () {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/recipes/{{$recipe->id}}/rate',
                type: 'POST',
                data: {_token: CSRF_TOKEN, rating: $(this).val()},
                dataType: 'JSON',
                success: function (response) {
                    $('.rating-success').toggle().delay(1000).fadeOut();
                }
            });

        });


    </script>
@endsection