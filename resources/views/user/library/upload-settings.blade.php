@extends('layouts.app')

@section('content')

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Account</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.image.library') }}">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Upload Settings</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Default Image Visibility</h5>
                        <span class="text-muted">You can set default image visibility here when you upload</span>
                        <hr>
                        <form action="{{ route('user.upload.settings.visibility', $settings->id) }}" method="POST">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="private" name="visibility" {{ $settings->default_image_visibility === 'private' ? 'checked' : '' }}>
                                        Private <small class="text-muted">(Only you can see it when logged in or shared via temporary URL)</small>
                                    </label>
                                </div>
                                <div class="form-check-inline mt-2">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="public" name="visibility" {{ $settings->default_image_visibility === 'public' ? 'checked' : '' }}>
                                        Public <small class="text-muted">(Anyone with URL can access it)</small>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success btn-block" type="submit">Save Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
