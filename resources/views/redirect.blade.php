@extends('layouts.app')


@section('content')

    <div class="container">

        <div class="card">
            <div class="card-body">
                <h4>Redirect Notice</h4>
                <hr>
                <p>
                    You are about to be redirected to:
                </p>

                <p>
                    <strong>{{ $shortUrl->original_url }}</strong>
                </p>

                <p>
                    Are you sure you would like to continue?
                </p>

                <p>
                    <a href="{{ $shortUrl->original_url }}" class="btn btn-warning">Continue</a>
                    <a href="{{ url()->previous() }}" class="btn btn-success">Go Back</a>
                </p>

            </div>
        </div>

    </div>

@endsection
