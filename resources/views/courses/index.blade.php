@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Available Courses</div>
                    <div class="panel-body">
                        <ul>
                            @foreach($courses as $course)
                                <li>{{ $course->name }}</li>
                            @endforeach
                        </ul>
                        <a href="/course/create/">Add a course...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection