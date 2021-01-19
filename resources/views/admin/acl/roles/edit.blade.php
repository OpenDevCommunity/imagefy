@extends('adminlte::page')

@section('title', config('app.name') . ' - Edit Role')

@section('content_header')
    <h1>Edit {{ $role->display_name }}</h1>
@stop

@section('content')
    <form action="{{ route('admin.update.role', $role->id) }}" method="POST">
        <div class="row">
            {{ csrf_field() }}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Role Information</h4>
                        <hr>
                        <div class="form-group">
                            <label for="name">Name (Internal)</label>
                            <input type="text" id="name" name="name" value="{{ $role->name }}" disabled class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="pname">Public Name</label>
                            <input type="text" id="pname" name="pname" value="{{ $role->display_name }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description" value="{{ $role->description }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit">Update {{ $role->display_name }} role</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Select Role Permissions</h4>
                        <hr>
                        @foreach($permissions as $permission)
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ $role->hasPermission($permission->name) ? 'checked' : '' }} id="permission-{{ $permission->id }}">
                                    <label for="permission-{{ $permission->id }}">
                                        {{ $permission->name }} <small>({{ $permission->description }})</small>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

