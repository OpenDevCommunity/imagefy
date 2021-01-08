@extends('adminlte::page')

@section('title', 'MD Share - Pending Invites')

@section('content_header')
    <h1>List Pending Invites</h1>
@stop

@section('content')


    <div class="conatiner">
        <div class="card">
            <div class="card-body table-responsive">
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
@stop
