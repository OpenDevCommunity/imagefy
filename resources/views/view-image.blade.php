@extends('layouts.app')

@section('content')
    <div class="container">

        @if (AWSImage::getFileVisibility($image->id) === 'private')
            <div class="alert alert-warning">
                <strong>NOTE! </strong> Current image is set to private. You can only see this image when you are logged in and are owner of the image. To make this image public head over to
                <a href="{{ route('user.image.settings', $image->image_share_hash) }}"><strong>Settings</strong></a> and set visibility to public
            </div>
       @endif

        <div class="card shadow-sm">
            <div class="card-body text-center">
                <a href="{{ AWSImage::generateTempLink($image->id, 5) }}" data-toggle="lightbox" data-gallery="gallery">
                    <img src="{{ AWSImage::generateTempLink($image->id, 5) }}" class="img-fluid rounded">
                </a>
            </div>
            <div class="card-footer">
                <span>Uploaded: {{ $image->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>


    <div class="modal" id="viewImg" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="imgViewer" style="overflow-x: scroll;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
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

