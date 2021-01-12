@extends('adminlte::page')

@section('title', 'MD Share - List Roles')

@section('content_header')
    <h1>List Roles</h1>
@stop

@section('content')

    <section class="mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#newRole">Create Role</button>
                <table id="roles" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Public Name</th>
                        <th>Internal Name</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Public Name</th>
                        <th>Internal Name</th>
                        <th>Description</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="newRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.store.role') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Name (Internal)</label>
                            <input type="text" name="name" id="name" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="pname">Public Name</label>
                            <input type="text" name="pname" id="pname" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control" />
                        </div>

                        <div style="max-height: 230px !important; overflow-y: auto;">
                            @foreach($permissions as $permission)
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="permissions[]"  id="role-{{ $permission->id }}">
                                        <label for="role-{{ $permission->id }}">
                                            {{ $permission->name }} <small>({{ $permission->description }})</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group" style="margin-top: 20px;">
                            <button class="btn btn-success btn-block" type="submit">Create new role</button>
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
            $('#roles').DataTable({
                "searching": true
            });
        } );
    </script>
@endsection
