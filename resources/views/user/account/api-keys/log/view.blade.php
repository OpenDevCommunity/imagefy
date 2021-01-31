@extends('layouts.app')


@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item"><a href="{{ route('api.settings') }}">API Keys</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.api.logs', $log->api_key_id) }}">API Key Logs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Log {{ $log->id }}</li>
            </ol>
        </nav>


        <div class="card shadow-sm">
            <div class="card-body">
                <h5>API Request Information</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                API Key ID
                                <span>{{ $log->api_key_id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Origin
                                <span>{{ $log->origin }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Method
                                <span class="badge badge-success">{{ $log->method }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Status
                                <span class="badge badge-{{ (int)$log->status === 500 || (int)$log->status === 422 ? 'danger' : 'success' }}">{{ $log->status }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                URI
                                <span>{{ $endpoint->uri }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Request Made
                                <span>{{ $log->created_at->diffForHumans() }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow-sm" style="margin-top: 20px;">
            <div class="card-body">
                <h5>Headers</h5>
                <hr>
                    <div class="trace">
                        @foreach($headers as $header => $key)
                            <strong>{{ $header }}</strong> => {{ $key[0] }}
                        @endforeach
                    </div>
            </div>
        </div>
    </div>

@endsection
