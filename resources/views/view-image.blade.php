@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <img src="{{ 'https://md-img-host.fra1.digitaloceanspaces.com/images/'.$image->image_name }}" alt="Image" class="img-responsive" style="max-width: 100%; min-height: 140px;" />
            </div>
            <div class="card-footer">
                <span>Uploaded: {{ $image->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>


    <div class="modal" id="viewImg" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="imgViewer" style="overflow-x: scroll;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('js')
    <script>

        $('img').on('click', function(e) {
            $('#imgViewer').html('').append( $(e.currentTarget).clone().removeClass('img-responsive').removeClass('img-thumbnail') )
            $('#viewImg').modal('show')
        })
    </script>
@endsection
