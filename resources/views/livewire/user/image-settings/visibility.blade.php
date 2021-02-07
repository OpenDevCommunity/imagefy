<div class="card shadow-sm">
    <div class="card-body">
        <h5>Image Visibility</h5>
        <span class="text-muted">You can set image visibility here</span>
        <hr>
        <form wire:submit.prevent="update" method="POST">
            <div class="form-group">
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" value="0" wire:model="visibility" name="visibility">
                        Private  <small class="text-muted"> (Only you can see it when logged in or shared via temporary URL)</small>
                    </label>
                </div>
                <div class="form-check-inline mt-2">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" value="1" wire:model="visibility" name="visibility">
                        Public <small class="text-muted">(Anyone with URL can access it)</small>
                    </label>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <button class="btn btn-success btn-sm btn-block">
                    <span wire:loading.remove wire:target="update">Save Settings</span>
                    <span wire:loading wire:target="update"><i class="fas fa-sync fa-spin"></i> &ensp; Saving Settings...</span>
                </button>
            </div>
        </form>
    </div>
</div>
