@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            @foreach($images as $image)
                <div class="col-lg-4 col-sm-12 clearfix" style="margin-bottom: 15px !important;">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <a href="{{ 'https://md-img-host.fra1.digitaloceanspaces.com/images/'.$image->image_name }}" data-toggle="lightbox" data-gallery="gallery">
                                <img src="{{ 'https://md-img-host.fra1.digitaloceanspaces.com/images/'.$image->image_name }}" class="img-fluid rounded">
                            </a>
                            <hr>
                            <p class="text-muted">Uploaded: {{ $image->created_at->diffForHumans() }}</p>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <a href="#" class="btn btn-success btn-sm btn-block">Edit</a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-danger btn-sm btn-block">Delete</a>
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
@endsection
