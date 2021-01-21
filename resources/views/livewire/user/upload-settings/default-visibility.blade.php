<div class="card shadow-sm">
    <div class="card-body">
        <h5>Default Image Visibility</h5>
        <span class="text-muted">You can set default image visibility here when you upload</span>
        <hr>
        <form wire:submit.prevent="update" method="POST">
            <div class="form-group">
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" value="private" wire:model="visibility" name="visibility">
                        Private <small class="text-muted">(Only you can see it when logged in or shared via temporary URL)</small>
                    </label>
                </div>
                <div class="form-check-inline mt-2">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" value="public" wire:model="visibility" name="visibility">
                        Public <small class="text-muted">(Anyone with URL can access it)</small>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-success btn-block" type="submit">
                    <span wire:loading.remove wire:target="update">Save Settings</span>
                    <span wire:loading wire:target="update"><i class="fas fa-sync fa-spin"></i> &ensp; Saving Settings</span></button>
            </div>
        </form>
    </div>
</div>
