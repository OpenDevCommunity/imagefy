<div wire:poll.10000="getUserImages">
    @if ($images->count() > 0)
    <div class="row">
        @foreach($images as $image)
            <livewire:user.library.image-component :image="$image" :key="$image->id"/>
        @endforeach
    </div>

    @else
        <div class="alert alert-warning shadow-sm">
            <strong>OOPS!</strong> Looks like you have no images yet! Head over to <a href="{{ route('api.settings') }}">API Settings</a> and download ShareX config for API you need!
        </div>
    @endif
</div>
