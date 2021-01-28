@extends('layouts.app')

@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item"><a href="{{ route('library') }}">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Upload Settings</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6">
                <livewire:user.upload-settings.default-visibility />
            </div>
        </div>

    </div>

@endsection
