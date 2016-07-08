@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add an ingredient</div>
                    <div class="panel-body">
                    @include('common.errors')
                        <form action="{{ url('ingredient') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label for="ingredient-name" class="col-sm-3 control-label">Ingredient Name:</label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" id="ingredient-name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-plus"></i> Add Ingredient
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection