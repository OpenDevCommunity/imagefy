@extends('adminlte::page')

@section('title', env('APP_NAME') . ' - Users List')

@section('content_header')
    <h1>List of Users</h1>
@stop

@section('content')
    <section class="mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="users" class="table table-striped table-bordered dt-responsive" style="width:100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cogs"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                                    <a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}"><i class="fas fa-eye"></i> View</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
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
