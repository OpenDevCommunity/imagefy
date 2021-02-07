@extends('layouts.app')


@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item"><a href="{{ route('api.settings') }}">API Keys</a></li>
                <li class="breadcrumb-item active" aria-current="page">API key Logs</li>
            </ol>
        </nav>


        <div class="card shadow-sm">
            <div class="card-body">
                <h5>API Key Request Logs</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table" aria-describedby="API Key Logs">
                        <thead>
                        <tr>
                            <th scope="col">Method</th>
                            <th scope="col">Origin</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($apiKeyLogs as $log)
                            <tr>
                                <td><span class="badge badge-success">{{ $log->method }}</span></td>
                                <td>{{ $log->origin }}</td>
                                <td><span class="badge badge-{{ (int)$log->status === 500 || (int)$log->status === 422 ? 'danger' : 'success' }}">{{ $log->status }}</span></td>
                                <td>{{ $log->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <em class="fas fa-cogs"></em>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('user.api.logs.show', $log->id) }}" class="dropdown-item" title="View Log Information">
                                                <em class="fas fa-eye"></em> &ensp; View
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 float-right">
                    {{ $apiKeyLogs->links() }}
                </div>
            </div>
        </div>


    </div>

@endsection
