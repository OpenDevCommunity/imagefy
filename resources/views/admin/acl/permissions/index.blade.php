@extends('adminlte::page')

@section('title', 'MD Share - List Permissions')

@section('content_header')
    <h1>List Permissions</h1>
@stop

@section('content')

    <section class="mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#newPermission">Create Permission</button>
                <table id="permissions" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Public Name</th>
                        <th>Internal Name</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->display_name }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->description }}</td>
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
    <div class="modal fade" id="newPermission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.store.permission') }}" method="POST">
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

                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit">Create new permission</button>
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
            $('#permissions').DataTable({
                "searching": true
            });
        } );
    </script>
@endsection
