<div>
    <div class="card shadow-sm">
        <div class="card-body">
            <button class="btn btn-success btn-sm float-right" wire:click="storeAPIKey">Generate Key</button>
            <h5>Your API Keys</h5>
            <br />

            @if (!$apiKeys || $apiKeys->count() < 1)
                <div class="alert alert-warning">
                    Looks like you do not have any API Keys
                </div>
            @else
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">API Key</th>
                        <th scope="col">Last Used</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($apiKeys as $key)
                    <tr>
                        <td>{{ $key['api_key'] }}</td>
                        <td>{{ $key['last_used'] ? \Carbon\Carbon::parse($key['last_used'])->diffForHumans() : 'Not Available' }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" wire:click="delete({{ $key['id'] }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
