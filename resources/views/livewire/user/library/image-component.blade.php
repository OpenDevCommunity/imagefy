<div class="col-lg-4 col-sm-12 clearfix" style="margin-bottom: 15px !important;">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <a href="{{ AWSImage::generateTempLink($image->image_name, 30) }}" data-toggle="lightbox" data-gallery="gallery">
                <img src="{{ AWSImage::generateTempLink($image->image_name, 30) }}" alt="{{ $image->image_name }}" class="img-fluid rounded">
            </a>
            <hr>
            <p>
                <span class="text-muted">Visibility: </span>
                <em class="text-success fas fa-{{ $image->public ? 'globe' : 'lock' }}"
                    title="{{ $image->public ? 'Public' : 'Private' }}"></em>
            </p>
            <p class="text-muted">Uploaded: {{ $image->created_at->diffForHumans() }}</p>
            <hr>
            <div class="dropdown">
                <a class="btn btn-secondary btn-block dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <em class="fas fa-cogs"></em> &ensp; Image Options
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('library.image.settings', $image->image_share_hash) }}">
                        <em class="fas fa-pencil-alt"></em> &ensp; Edit
                    </a>

                    <button class="dropdown-item" wire:click="confirmDelete({{ $image->id }})">
                        <em class="fas fa-trash"></em> &ensp; Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
