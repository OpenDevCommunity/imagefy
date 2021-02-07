<div class="card shadow-sm">
    <div class="card-body">
        <h5>URL to share your images &ensp; <span wire:loading><i class="fas fa-sync fa-spin"></i></span></h5>
        <span class="text-muted">Use bellow URLS to share this image</span>
        <hr>
        <div>
            @if ($image->public)
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
                    <input type="text" id="markdown_link" class="form-control" value="[{{ config('app.name') }}]({{ route('frontend.show.image', [$image->image_share_hash, 'full' => 'true']) }})" readonly>
                </div>

                <div class="form-group">
                    <label for="html_link">Markdown Link</label>
                    <input type="text" id="html_link" class="form-control" value='<a href="{{ route('frontend.show.image', $image->image_share_hash) }}"><img src="{{ route('frontend.show.image', [$image->image_share_hash, 'full' => 'true']) }}" title="source: {{ config('app.name') }} " /></a>' readonly>
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
