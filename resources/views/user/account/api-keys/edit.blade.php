@extends('layouts.app')

@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item"><a href="{{ route('api.settings') }}">API Keys</a></li>
                <li class="breadcrumb-item active" aria-current="page">API Key Settings</li>
            </ol>
        </nav>

        @if ($apikey->blocked)
            <div class="alert alert-danger">
                <strong>NOTE</strong> Looks like this API key has been disabled by member of staff and it's not possible to self-reactivate it. Please contact us at support@imagefy.me for support.
            </div>
        @endif


        <div class="section mt-3">
            <livewire:user.api-settings :keyId="$apikey['id']" />
        </div>

    </div>
@endsection
