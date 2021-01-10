@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Statistics -->

    <div class="row">

        <!-- Statistic Item -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1>{{ $imagesCount }}</h1>
                    <p class="text-muted">Uploaded Images</p>
                </div>
            </div>
        </div>
        <!-- ./ Statistic Item -->


        <!-- Statistic Item -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1>{{ $publicImagesCount }}</h1>
                    <p class="text-muted">Public Images</p>
                </div>
            </div>
        </div>
        <!-- ./ Statistic Item -->


        <!-- Statistic Item -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1>0</h1>
                    <p class="text-muted">Private Files</p>
                </div>
            </div>
        </div>
        <!-- ./ Statistic Item -->


        <!-- Statistic Item -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1>0</h1>
                    <p class="text-muted">Uploaded Files</p>
                </div>
            </div>
        </div>
        <!-- ./ Statistic Item -->

    </div>

    <!-- ./ Statistics -->
</div>


    <section class="mt-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="{{ route('user.image.library') }}" class="btn btn-success btn-sm float-right">View All</a>
                    <h5>Your Recently Uploaded Images</h5>
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Uploaded</th>
                                <th scope="col">Visibility</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentImages as $img)
                                <tr>
                                    <td>
                                        <a href="{{ AWSImage::generateTempLink($img->image_name, 5) }}" data-toggle="lightbox" data-gallery="gallery">
                                            {{ $img->image_name }}
                                        </a>
                                    </td>
                                    <td>{{ $img->created_at->diffForHumans() }}</td>
                                    <td>
                                        <i class="text-success fas fa-{{ AWSImage::getFileVisibility($img->id) === 'public' ? 'globe' : 'lock' }}"
                                           title="{{ AWSImage::getFileVisibility($img->id) === 'public' ? 'Public' : 'Private' }}"></i>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.image.settings', $img->image_share_hash) }}" class="btn btn-primary btn-sm" title="Edit Image">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="{{ route('user.image.delete', $img->image_del_hash) }}" class="btn btn-danger btn-sm delete-confirm" title="Delete Image">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
