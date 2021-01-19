@extends('adminlte::page')

@section('title', config('app.name') . ' - Pending Invites')

@section('content_header')
    <h1>List Pending Invites</h1>
@stop

@section('content')

    <section class="mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#newInvite">Send New Invite</button>
                <table id="pendingInvites" class="table table-striped table-bordered dt-responsive" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Requested</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pendingInvites as $invite)
                        <tr>
                            <td>{{ $invite->id }}</td>
                            <td>{{ $invite->email }}</td>
                            <td>{{ $invite->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cogs"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('admin.invites.accept', $invite->id) }}"><i class="fas fa-check"></i> Accept</a>
                                        <a class="dropdown-item" href="{{ route('admin.invites.deny', $invite->id) }}"><i class="fas fa-times"></i> Reject</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Requested</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="newInvite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send New Invite</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.invites.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" />
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit">Create & Send Invite</button>
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
            $('#pendingInvites').DataTable({
                "searching": true
            });
        } );
    </script>
@endsection
