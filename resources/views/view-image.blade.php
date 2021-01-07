@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <img src="{{ 'https://md-img-host.fra1.digitaloceanspaces.com/images/'.$image->image_name }}" alt="Image" class="img-responsive" style="max-width: 100%; min-height: 140px;" />
            </div>
            <div class="card-footer">
                <span>Uploaded: {{ $image->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>


@endsection
