@extends('layouts.app')

@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">API Keys</li>
            </ol>
        </nav>

        <livewire:list-api-keys />

    </div>

@endsection
