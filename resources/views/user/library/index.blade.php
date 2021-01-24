@extends('layouts.app')

@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Your Images Library</li>
                <li class="breadcrumb-item active float-right"><span class="text-muted float-right"><em class="fas fa-sync fa-spin"></em> &ensp; Waiting for images...</span></li>
            </ol>
        </nav>

        <livewire:user.library />

    </div>

@endsection

@section('js')
    <script>
        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
@endsection
