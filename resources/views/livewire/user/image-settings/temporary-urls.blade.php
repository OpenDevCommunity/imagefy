<div class="card shadow-sm">
    <div class="card-body">
        <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#tempurlmodal">Generate URL</button>
        <a class="btn btn-success btn-sm float-right" style="margin-right: 5px;" href="{{ route('short.urls') }}">View All</a>
        <h5>Temporary URLs</h5>
        <span class="text-muted">You can generate temporary URLs to share your image</span>
        <hr>
        <div class="table-responsive">
            <table class="table" aria-describedby="Templorary URLs table">
                <thead>
                <tr>
                    <th scope="col">Share URL</th>
                    <th scope="col">Expiries</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($image->shorturls as $tmpUrl)
                    <tr>
                        <td><input type="text" class="form-control" value="{{ route('frontend.shorturl', $tmpUrl->short_url_hash)}}" readonly></td>
                        <td>{{ \Carbon\Carbon::parse($tmpUrl->expiries_at)->isPast() ? 'Expiried' : 'Expiries in ' . \Carbon\Carbon::parse($tmpUrl->expiries_at)->diffForHumans() }}</td>
                        <td>
                            <button class="btn btn-success btn-icon" wire:click="confirmDelete({{ $tmpUrl->id }})"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tempurlmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generate Temporary URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="generateTempURL" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time">Time</label>
                                    <input type="number" name="time" wire:model.lazy="time" id="time" min="1" value="5" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="length">Length</label>
                                    <select wire:model.lazy="length" id="length" class="form-control">
                                        <option value="" selected>Please Select</option>
                                        <option value="minutes">Minutes</option>
                                        <option value="hours">Hours</option>
                                        <option value="days">Days</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-block" data-hide="modal" type="submit">Create Temporary URL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
