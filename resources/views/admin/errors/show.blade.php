@extends('adminlte::page')

@section('title', env('APP_NAME') . ' - Administration Errors Index')

@section('content_header')
    <h1>View Error</h1>
@stop

@section('content')

    <div class="conatiner">
        <section class="mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Error Information</h5>
                        <span class="text-muted">Error information</span>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Code: </strong>{{ $error->code }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Occured: </strong>{{ $error->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.errors.delete', $error->id) }}" data-text="This error log will be permanently deleted" class="btn btn-danger delete-confirm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <section class="mt-3">
            <div class="card">
                <div class="card-body">
                    <h5>Error Message</h5>
                    <span class="text-muted">Error message</span>
                    <hr>
                    <div class="trace">
                        {{ $error->message }}
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-3">
            <div class="card">
                <div class="card-body">
                    <h5>Trace</h5>
                    <span class="text-muted">Error trace information</span>
                    <hr>
                    <div class="trace">
                        {{ $error->trace }}
                    </div>
                </div>
            </div>
        </section>
    </div>


@stop


