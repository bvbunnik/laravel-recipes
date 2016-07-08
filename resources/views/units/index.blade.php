@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Available Units</div>
                    <div class="panel-body">
                        <ul>
                            @foreach($units as $unit)
                                <li>{{ $unit->name }} ({{ $unit->abbreviation }})</li>
                            @endforeach
                        </ul>
                        <a href="unit/create/">Add a unit...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection