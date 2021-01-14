@extends('adminlte::page')

@section('title', env('APP_NAME') . ' - Edit User')

@section('content_header')
    <h1>Edit {{ $user->name }}</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4>User Infomration</h4>
                <hr>
                <form action="{{ route('admin.users.update.information', $user->id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success btn-block">Save Infomration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4>User Roles</h4>
                <hr>
                <form action="{{ route('admin.users.sync.roles', $user->id) }}" method="POST">
                    {{ csrf_field() }}
                        @foreach($roles as $role)
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" name="roles[]" {{ $user->hasRole($role->name) ? 'checked' : '' }} value="{{ $role->id }}" id="role-{{ $role->id }}">
                                    <label for="role-{{ $role->id }}">
                                        {{ $role->name }} <small>({{ $role->description }})</small>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    <div class="form-group">
                        <button class="btn btn-success btn-block">Save Roles</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop


@section('js')
    <script>
        $(document).ready(function() {
            $('#users').DataTable({
                "searching": true
            });
        } );
    </script>
@endsection
