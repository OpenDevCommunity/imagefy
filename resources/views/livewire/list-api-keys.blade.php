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
                        <td><kbd>{{ $key->api_key }}</kbd></td>
                        <td>{{ $key->last_used ? \Carbon\Carbon::parse($key['last_used'])->diffForHumans() : 'Not Available' }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <em class="fas fa-cogs"></em>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('api.configuration', ['id' => $key->id]) }}"><em class="fas fa-cog"></em> &ensp; API Key Settings</a>
                                    <a class="dropdown-item" href="{{ route('sharex.config.download',  ['id' => $key->id, 'type' => 'upload']) }}"><em class="fas fa-download"></em> &ensp; Sharex Config</a>
                                    <a class="dropdown-item" href="{{ route('sharex.config.download', ['id' => $key->id, 'type' => 'surl']) }}"><em class="fas fa-download"></em> &ensp; Sharex s-url Config</a>
                                    <a class="dropdown-item" href="{{ route('user.api.logs', $key->id) }}"><em class="fas fa-list"></em> &ensp; Logs</a>
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click.prevent="confirm({{ $key->id }})"><em class="fas fa-trash"></em> &ensp; Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
