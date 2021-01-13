@extends('layouts.app')

@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Your Images Library</li>
            </ol>
        </nav>

        <div class="row">
            @foreach($images as $image)
                <div class="col-lg-4 col-sm-12 clearfix" style="margin-bottom: 15px !important;">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <a href="{{ AWSImage::generateTempLink($image->image_name, 30) }}" data-toggle="lightbox" data-gallery="gallery">
                                <img src="{{ AWSImage::generateTempLink($image->image_name, 30) }}" class="img-fluid rounded">
                            </a>
                            <hr>
                            <p>
                                <span class="text-muted">Visibility: </span>
                                <i class="text-success fas fa-{{ AWSImage::getFileVisibility($image->id) === 'public' ? 'globe' : 'lock' }}"
                                   title="{{ AWSImage::getFileVisibility($image->id) === 'public' ? 'Public' : 'Private' }}"></i>
                            </p>
                            <p class="text-muted">Uploaded: {{ $image->created_at->diffForHumans() }}</p>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('user.image.settings', $image->image_share_hash) }}" class="btn btn-success btn-sm btn-block">Edit</a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('user.image.delete', $image->image_del_hash) }}" class="btn btn-danger btn-sm btn-block delete-confirm">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>

    <script>
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Are you sure?',
                text: 'This image and it`s details will be permanantly deleted!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
