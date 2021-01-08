@extends('adminlte::page')

@section('title', 'MD Share - Pending Invites')

@section('content_header')
    <h1>List Pending Invites</h1>
@stop

@section('content')


    <div class="conatiner">
        <div class="card">
            <div class="card-body table-responsive">
                <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#newInvite">Send New Invite</button>
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Date</th>
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
                            <a href="{{ route('admin.invites.accept', $invite->id) }}" class="btn btn-success btn-sm">Accept</a>
                            <a href="{{ route('admin.invites.deny', $invite->id) }}" class="btn btn-danger btn-sm">Deny</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


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
