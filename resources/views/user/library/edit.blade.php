@extends('layouts.app')

@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item"><a href="{{ route('library') }}">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Image Settings</li>
            </ol>
        </nav>

        <div class="row">

            <div class="col-lg-6 mx- mt-3">
                <livewire:user.image-settings.visibility :imageId="$image['id']"/>
            </div>


            <div class="col-lg-12 mx-auto mt-3">
                <livewire:user.image-settings.share-links  :imageId="$image['id']"/>
            </div>


            <div class="col-lg-12 mx-auto mt-3">
                <livewire:user.image-settings.temporary-urls  :imageId="$image['id']"/>
            </div>
        </div>
    </div>

@endsection
