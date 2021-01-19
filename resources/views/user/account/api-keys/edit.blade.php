@extends('layouts.app')

@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.settings.api') }}">API Keys</a></li>
                <li class="breadcrumb-item active" aria-current="page">API Key Settings</li>
            </ol>
        </nav>

        @if ($apikey->blocked)
            <div class="alert alert-danger">
                <strong>NOTE</strong> Looks like this API key has been disabled by member of staff and it's not possible to self-reactivate it. Please contact us at support@imagefy.me for support.
            </div>
        @endif


        <div class="section mt-3">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('user.settings.api.update', $apikey->id) }}" method="POST">
                        {{ csrf_field() }}
                        <div>
                            <h5>Edit API Key Configuration</h5>
                            <span class="text-muted">Here you can configure your API Key settings</span>
                            <hr>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" value="true" {{ $apikey->enabled ? 'checked' : '' }} name="enabled" id="enabled">
                            <label class="form-check-label" for="enabled">Enable / Disable API Key</label>
                        </div>


                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ $apikey->name }}" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label for="key">API Key</label>
                            <input type="text" name="key" id="key" value="{{ $apikey->api_key }}" disabled class="form-control">
                        </div>


                        <div class="form-group">
                            <label for="last_used">Last Used</label>
                            <input type="text" name="last_used" id="last_used" value="{{ $apikey->last_used ? $apikey->last_used->diffForHumans() : 'Not Yet Used' }}" disabled class="form-control">
                        </div>


                        <div class="mt-3">
                            <br />
                            <h5>Allowed Origin <span class="badge badge-success">Beta</span></h5>
                            <span class="text-muted">To better protect your API Key you can setup allowed origin to make request with this API Key</span>
                            <hr>
                        </div>

                        <div class="form-group">
                            <label for="allowed_origin">Allowed Origin</label>
                            <input type="text" name="allowed_origin" id="allowed_origin" value="{{ $apikey->allowed_origin }}" class="form-control">
                            <small id="emailHelp" class="form-text text-muted">Enter single domain only! Eg: imagefy.me | * is supported but not recommended</small>
                        </div>


                        <div class="mt-3">
                            <br />
                            <h5>API Logs <span class="badge badge-success">Beta</span></h5>
                            <span class="text-muted">You can enable/Disable API request logging</span>
                            <hr>
                        </div>


                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" value="true" {{ $apikey->logs_enabled ? 'checked' : '' }} name="logs_enabled" id="logs_enabled">
                            <label class="form-check-label" for="logs_enabled">Enable / Disable API Logs</label>
                        </div>


                        <div class="mt-3">
                            <br />
                            <h5>API Key Permissions <span class="badge badge-success">Beta</span></h5>
                            <span class="text-muted">Set API Read/Write permissions</span>
                            <hr>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" value="true" {{ $apikey->can_read ? 'checked' : '' }} name="can_read" id="can_read">
                            <label class="form-check-label" for="can_read">Allow read access</label>
                        </div>


                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" value="true" {{ $apikey->can_write ? 'checked' : '' }} name="can_write" id="can_write">
                            <label class="form-check-label" for="can_write">Allow write access <small>(Required to upload images & Short URLs)</small></label>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block" {{ $apikey->blocked ? 'disabled' : '' }}>Update Information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
