@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Available Ingredients</div>
                    <div class="panel-body">
                        <ul>
                            @foreach($ingredients as $ingredient)
                                <li>{{ $ingredient->name }}</li>
                            @endforeach
                        </ul>
                        <a href="ingredient/create/">Add an ingredient...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection