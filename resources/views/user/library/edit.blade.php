@extends('layouts.app')

@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.image.library') }}">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Image Settings</li>
            </ol>
        </nav>

        <div class="row">

            <div class="col-lg-6 mx- mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Image Visibility</h5>
                        <span class="text-muted">You can set image visibility here</span>
                        <hr>
                        <form action="{{ route('user.image.settings.visibility', $image->id) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="private" {{ AWSImage::getFileVisibility($image->id) === 'private' ? 'checked' : '' }} name="visibility">Private (Only you can see it when logged in)
                                    </label>
                                </div>
                                <div class="form-check-inline mt-2">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="public" {{ AWSImage::getFileVisibility($image->id) === 'public' ? 'checked' : '' }} name="visibility">Public (Anyone with URL can access it)
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <button class="btn btn-success btn-sm btn-block">Update Visibility Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        <div class="col-lg-12 mx-auto mt-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>URL to share your images</h5>
                    <span class="text-muted">Use bellow URLS to share this image</span>
                    <hr>
                    @if (AWSImage::getFileVisibility($image->id) === 'public')
                        <div class="form-group">
                            <label for="image_link">Image Link</label>
                            <input type="text" id="image_link" class="form-control" value="{{ route('frontend.show.image', $image->image_share_hash) }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="direct_link">Direct Link</label>
                            <input type="text" id="direct_link" class="form-control" value="{{ route('frontend.show.image', [$image->image_share_hash, 'full' => 'true']) }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="markdown_link">Markdown Link</label>
                            <input type="text" id="markdown_link" class="form-control" value="[MD Share]({{ route('frontend.show.image', [$image->image_share_hash, 'full' => 'true']) }})" readonly>
                        </div>

                        <div class="form-group">
                            <label for="html_link">Markdown Link</label>
                            <input type="text" id="html_link" class="form-control" value='<a href="{{ route('frontend.show.image', $image->image_share_hash) }}"><img src="{{ route('frontend.show.image', [$image->image_share_hash, 'full' => 'true']) }}" title="source: " /></a>' readonly>
                        </div>

                        <div class="form-group">
                            <label for="bbcode_link">BBCode</label>
                            <input type="text" id="bbcode_link" class="form-control" value="[img]{{ route('frontend.show.image', [$image->image_share_hash, 'full' => 'true']) }}[/img]" readonly>
                        </div>

                    @else
                        <div class="alert alert-warning">
                            Image sharing URLs will be available once image is set to <strong>Public</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>


            <div class="col-lg-12 mx-auto mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#tempurlmodal">Generate URL</button>
                        <a class="btn btn-success btn-sm float-right" style="margin-right: 5px;" href="{{ route('user.short.urls') }}">View All</a>
                        <h5>Temporary URLs</h5>
                        <span class="text-muted">You can generate temporary URLs to share your image</span>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Share URL</th>
                                    <th scope="col">Expiries</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($image->shorturls as $tmpUrl)
                                <tr>
                                    <td><input type="text" class="form-control" value="{{ route('frontend.shorturl', $tmpUrl->short_url_hash)}}" readonly></td>
                                    <td width="350">{{ \Carbon\Carbon::parse($tmpUrl->expiries_at)->isPast() ? 'Expiried' : 'Expiries in ' . \Carbon\Carbon::parse($tmpUrl->expiries_at)->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="tempurlmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generate Temporary URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.images.temp', $image->id) }}" method="POST">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time">Time</label>
                                    <input type="number" name="time" id="time" min="1" value="5" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="length">Length</label>
                                    <select name="length" id="length" class="form-control">
                                        <option value="minutes">Minutes</option>
                                        <option value="hours">Hours</option>
                                        <option value="days">Days</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit">Create Temporary URL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
