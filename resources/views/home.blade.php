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
                    <h1>0</h1>
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
                    <a href="#" class="btn btn-success btn-sm float-right">View All</a>
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
                                    <td><a href="{{ route('frontend.show.image', $img->image_share_hash) }}" target="_blank">{{ $img->image_name }}</a></td>
                                    <td>{{ $img->created_at->diffForHumans() }}</td>
                                    <td>
                                        <i class="text-success fas fa-{{ \App\Helpers\ImageHelper::getFileVisibility($img->id) === 'public' ? 'globe' : 'lock' }}"
                                           title="{{ \App\Helpers\ImageHelper::getFileVisibility($img->id) === 'public' ? 'Public' : 'Private' }}"></i>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.image.settings', $img->image_share_hash) }}" class="btn btn-primary btn-sm" title="Edit Image">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="{{ route('user.image.delete', $img->image_del_hash) }}" class="btn btn-danger btn-sm" title="Delete Image">
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
