@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Available Cuisines</div>
                    <div class="panel-body">
                        <ul>
                            @foreach($cuisines as $cuisine)
                                <li>{{ $cuisine->name }}</li>
                            @endforeach
                        </ul>
                        <a href="cuisine/create/">Add a cuisine...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection