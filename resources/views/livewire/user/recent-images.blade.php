<div class="container" wire:poll.10000ms="getUserImages">
    <div class="card shadow-sm">
        <div class="card-body">
            <a href="{{ route('library') }}" class="btn btn-success btn-sm float-right">View All</a>
            <button wire:click="getUserImages()" style="margin-right: 5px;" class="btn btn-success btn-sm float-right">Refresh</button>
            <h5>Your recently uploaded images</h5>
            <span class="text-muted"><i class="fas fa-sync fa-spin"></i> &ensp; Waiting for images...</span>
            <hr>
            <div class="table-responsive" wire:loading.remove wire:target="delete">
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
                                <a href="{{ AWSImage::generateTempLink($img->image_name, 30) }}" data-toggle="lightbox" data-gallery="gallery">
                                    {{ $img->image_name }}
                                </a>
                            </td>
                            <td>{{ $img->created_at->diffForHumans() }}</td>
                            <td>
                                <i class="text-success fas fa-{{ AWSImage::getFileVisibility($img->id) === 'public' ? 'globe' : 'lock' }}"
                                   title="{{ AWSImage::getFileVisibility($img->id) === 'public' ? 'Public' : 'Private' }}"></i>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cogs"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('library.image.settings', $img->image_share_hash) }}" class="dropdown-item" title="Edit Image">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>

                                        <button class="dropdown-item" wire:click="confirm({{ $img->id }})" title="Delete Image">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div wire:loading wire:target="delete">
                Processing your request... Please wait...
            </div>
        </div>
    </div>
</div>
