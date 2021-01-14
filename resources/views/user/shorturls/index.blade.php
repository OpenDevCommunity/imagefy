@extends('layouts.app')

@section('content')

    <div class="container">

        <!-- Statistics -->

        <div class="row">

            <!-- Statistic Item -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1>{{ $shortURLSCount }}</h1>
                        <p class="text-muted">All URLs</p>
                    </div>
                </div>
            </div>
            <!-- ./ Statistic Item -->


            <!-- Statistic Item -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1>0</h1>
                        <p class="text-muted">Clicks</p>
                    </div>
                </div>
            </div>
            <!-- ./ Statistic Item -->


            <!-- Statistic Item -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1>{{ $expiriedURLS }}</h1>
                        <p class="text-muted">Expired URLs</p>
                    </div>
                </div>
            </div>
            <!-- ./ Statistic Item -->


            <!-- Statistic Item -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1>0</h1>
                        <p class="text-muted">URLs This Month</p>
                    </div>
                </div>
            </div>
            <!-- ./ Statistic Item -->

        </div>

        <!-- ./ Statistics -->
    </div>

        <section class="mt-4">
            <div class="container">
                @foreach($shortUrls as $sh)
                    <div class="card shadow-sm" style="margin-top: 15px;">
                        <div class="card-body">
                            <h5>{{ $sh->name ? $sh->name : 'Not Available' }}</h5>
                            <hr>
                            <div>
                                <p><strong>Original URL</strong></p>
                                <a href="{{ $sh->original_url }}">{{ Str::limit($sh->original_url, 130) }}</a>
                            </div>
                            <br>
                            <div>
                                <p><strong>Short URL</strong></p>
                                <p><a id="link" href="{{ route('frontend.shorturl', $sh->short_url_hash) }}">{{ route('frontend.shorturl', $sh->short_url_hash) }}</a></p>
                            </div>

                            @if ($sh->expiried)
                            <div class="alert alert-warning">
                                This short URL has expired and will no longer redirect to required page! This URL expired {{ \Carbon\Carbon::parse($sh->expiries_at)->fromNow() }}
                            </div>
                           @endif
                        </div>
                    </div>
                @endforeach
                <div class="mt-4 float-right">
                    {{ $shortUrls->links() }}
                </div>
            </div>
        </section>
        @endsection
