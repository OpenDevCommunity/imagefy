<div class="card shadow-sm">
    <div class="card-body">

        <div wire:loading wire:target="update">
            <p>Saving Settings... Please wait &ensp; <span wire:loading><i class="fas fa-sync fa-spin"></i></span></p>
        </div>

        <form wire:submit.prevent="update" method="POST" wire:loading.remove>
            <div>
                <h5>Edit API Key Configuration</h5>
                <span class="text-muted">Here you can configure your API Key settings</span>
                <hr>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" wire:model="enabled" name="enabled" id="enabled">
                <label class="form-check-label" for="enabled">Enable / Disable API Key</label>
            </div>


            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" wire:model="name" class="form-control" required>
            </div>


            <div class="form-group">
                <label for="key">API Key</label>
                <input type="text" name="key" id="key" value="{{ $apiKey->api_key }}" disabled class="form-control">
            </div>


            <div class="form-group">
                <label for="last_used">Last Used</label>
                <input type="text" name="last_used" id="last_used" value="{{ $apiKey->last_used ? $apiKey->last_used->diffForHumans() : 'Not Yet Used' }}" disabled class="form-control">
            </div>


            <div class="mt-3">
                <br />
                <h5>Allowed Origin <span class="badge badge-success">Beta</span></h5>
                <span class="text-muted">To better protect your API Key you can setup allowed origin to make request with this API Key</span>
                <hr>
            </div>

            <div class="form-group">
                <label for="allowed_origin">Allowed Origin</label>
                <input type="text" name="allowed_origin" id="allowed_origin" wire:model="allowedOrigin" class="form-control">
                <small id="emailHelp" class="form-text text-muted">Enter single domain only! Eg: imagefy.me | * is supported but not recommended</small>
            </div>


            <div class="mt-3">
                <br />
                <h5>API Logs <span class="badge badge-success">Beta</span></h5>
                <span class="text-muted">You can enable/Disable API request logging</span>
                <hr>
            </div>


            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" value="true" wire:model="logsEnabled" name="logs_enabled" id="logs_enabled">
                <label class="form-check-label" for="logs_enabled">Enable / Disable API Logs</label>
            </div>


            <div class="mt-3">
                <br />
                <h5>API Key Permissions <span class="badge badge-success">Beta</span></h5>
                <span class="text-muted">Set API Read/Write permissions</span>
                <hr>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" wire:model="canRead" name="can_read" id="can_read">
                <label class="form-check-label" for="can_read">Allow read access</label>
            </div>


            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" wire:model="canWrite" name="can_write" id="can_write">
                <label class="form-check-label" for="can_write">Allow write access <small>(Required to upload images & Short URLs)</small></label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block" {{ $apiKey->blocked ? 'disabled' : '' }}>Update Information</button>
            </div>
        </form>
    </div>
</div>
