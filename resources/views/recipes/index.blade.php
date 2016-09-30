@extends('layouts.app')

@section('content')


    <div class="recipe">
        <div class="container">
            @foreach(array_chunk($recipes->all(),4) as $recipesRow)
                <div class="card-deck-wrapper">
                    <div class="card-deck">
                    @foreach($recipesRow as $recipe)
                        <div class="card">
                            <h5 class="card-title"><a href="/recipes/{{$recipe->id}}/">{{ $recipe->title }}</a></h5>
                            <img class="card-img" src="{{url($recipe->photo)}}" alt="Card image">

                            <div class="card-block">
                                <div class="pull-right">Rating: <input type="hidden" class="rating" data-fractions="2" value="{{$recipe->rating}}" data-readonly/></div>
                            </div>

                            <div class="card-footer text-muted">
                                <a href="" class="pull-lg-right">Add to favourites</a>
                                <div class="pull-lg-left">Last prepared: 2 days ago</div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            @endforeach
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
    </script>
@endsection