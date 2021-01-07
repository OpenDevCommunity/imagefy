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
                    <p class="text-muted">Uploaded Files</p>
                </div>
            </div>
        </div>
        <!-- ./ Statistic Item -->


        <!-- Statistic Item -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1>0</h1>
                    <p class="text-muted">Public Files</p>
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
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Uploaded</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recentImages as $img)
                            <tr>
                                <th scope="row">{{ $img->id }}</th>
                                <td><a href="{{ route('frontend.show.image', $img->image_share_hash) }}">{{ $img->image_name }}</a></td>
                                <td>{{ $img->created_at->diffForHumans() }}</td>
                                <td>@mdo</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
