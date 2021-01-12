@extends('adminlte::page')

@section('title', 'MD Share - Users List')

@section('content_header')
    <h1>List of Users</h1>
@stop

@section('content')
    <section class="mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="users" class="table table-striped table-bordered" style="width:100%">
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
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
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
