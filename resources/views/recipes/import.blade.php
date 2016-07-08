@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Import a recipe</div>
                    <div class="panel-body">
                        @include('common.errors')
                        <div class="controls">
                            <form role="form" action="{{ url('recipes/import') }}" method="POST" class="form-horizontal">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="url" class="col-sm-2 control-label">URL:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="url" id="url" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-plus"></i> Import Recipe
                                        </button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection