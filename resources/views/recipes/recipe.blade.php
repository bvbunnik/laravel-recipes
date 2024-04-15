@extends('layouts.app')

@section('content')
<script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Recipe",
      "name": @json($recipe->title),
      "image": [
        @json($recipe->photo)
      ],
      "description": @json($recipe->description),
      "recipeCuisine": @json($recipe->cuisine->name),
      "prepTime": "PT1M",
      "cookTime": "PT2M",
      "totalTime": "PT3M",
      "keywords": "non-alcoholic",
      "recipeYield": "4 servings",
      "recipeCategory": "Drink",
      "nutrition": {
        "@type": "NutritionInformation",
        "calories": "120 calories"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "5",
        "ratingCount": "18"
      },
      "recipeIngredient": [
        "400ml of pineapple juice",
        "100ml cream of coconut",
        "ice"
      ],
      "recipeInstructions": [
        {
          "@type": "HowToStep",
          "name": "Blend",
          "text": "Blend 400ml of pineapple juice and 100ml cream of coconut until smooth.",
          "url": "https://example.com/non-alcoholic-pina-colada#step1",
          "image": "https://example.com/photos/non-alcoholic-pina-colada/step1.jpg"
        },
        {
          "@type": "HowToStep",
          "name": "Fill",
          "text": "Fill a glass with ice.",
          "url": "https://example.com/non-alcoholic-pina-colada#step2",
          "image": "https://example.com/photos/non-alcoholic-pina-colada/step2.jpg"
        },
        {
          "@type": "HowToStep",
          "name": "Pour",
          "text": "Pour the pineapple juice and coconut mixture over ice.",
          "url": "https://example.com/non-alcoholic-pina-colada#step3",
          "image": "https://example.com/photos/non-alcoholic-pina-colada/step3.jpg"
        }
      ],
      "video": {
        "@type": "VideoObject",
        "name": "How to Make a Non-Alcoholic Piña Colada",
        "description": "This is how you make a non-alcoholic piña colada.",
        "thumbnailUrl": [
          "https://example.com/photos/1x1/photo.jpg",
          "https://example.com/photos/4x3/photo.jpg",
          "https://example.com/photos/16x9/photo.jpg"
         ],
        "contentUrl": "https://www.example.com/video123.mp4",
        "embedUrl": "https://www.example.com/videoplayer?video=123",
        "uploadDate": "2018-02-05T08:00:00+08:00",
        "duration": "PT1M33S",
        "interactionStatistic": {
          "@type": "InteractionCounter",
          "interactionType": { "@type": "WatchAction" },
          "userInteractionCount": 2347
        },
        "expires": "2019-02-05T08:00:00+08:00"
       }
    }
    </script>
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
            <div class="row">
                <div class="col-md-6">
                    {{ Form::open(['method' => 'DELETE', 'route' => ['recipes.destroy', $recipe]]) }}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                    {{ Form::close() }}
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