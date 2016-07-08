@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add a unit</div>
                    <div class="panel-body">
                    @include('common.errors')
                        <form action="{{ url('unit') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label for="unit-name" class="col-sm-3 control-label">Unit Name:</label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" id="unit-name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="unit-abbr" class="col-sm-3 control-label">Unit Abbreviation:</label>
                                <div class="col-sm-6">
                                    <input type="text" name="abbreviation" id="unit-abbr" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-plus"></i> Add Unit
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