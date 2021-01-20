@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Statistics -->

    <livewire:user.home-statistics />

    <!-- ./ Statistics -->
</div>
    <section class="mt-4">
        <livewire:user.recent-images />
    </section>
@endsection

@section('js')
    <script>
        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
@endsection
