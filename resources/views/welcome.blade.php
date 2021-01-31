@extends('layouts.landing')

@section('content')
<!--Navbar Start-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="navbar">
    <div class="container">
        <!-- LOGO -->
        <a class="navbar-brand logo" href="/">
            <h4>{{ config('app.name') }}</h4>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <em class="" data-feather="menu"></em>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto navbar-center" id="navbar-navlist">
                <li class="nav-item">
                    <a href="#home" class="nav-link active">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#features" class="nav-link">Features</a>
                </li>
                <li class="nav-item">
                    <a href="https://hub.opendevcommunity.com/docs/img" class="nav-link">Documentation</a>
                </li>
                <li class="nav-item">
                    <a href="https://hub.opendevcommunity.com/git/imagefy/imagefy" class="nav-link">GitLab Repository</a>
                </li>
            </ul>
            @if (Auth::guest())
                <a href="{{ route('login') }}" class="btn btn-sm rounded-pill nav-btn ms-lg-3">
                    Authenticate
                </a>
            @else
                <a href="{{ route('home') }}" class="btn btn-sm rounded-pill nav-btn ms-lg-3">
                    Account Dashboard
                </a>
            @endif

        </div>
    </div>
    <!-- end container -->
</nav>
<!-- Navbar End -->

<!-- Hero Start -->
<section class="hero-3 bg-center position-relative" style="background-image: url({{ asset('theme/images/hero-3-bg.png') }});" id="home">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <span class="badge badge-soft-primary mb-4">
                        <span>@version</span>
                        ({{ \Carbon\Carbon::parse(Version::format('timestamp-full'))->fromNow() }})
                    </span>
                    <h1 class="font-weight-semibold mb-4 hero-3-title">Image sharing & URL Shortener</h1>
                    <p class="mb-5 text-muted subtitle w-75 mx-auto">{{ config('app.name') }} is a media sharing & URL shortener that allows you to take
                    full control over how you share media such as screenshots, gifs online</p>

                    <div>
                        <a href="{{ route('frontend.auth.request') }}" type="button" class="btn btn-primary rounded-pill me-2">Request Invite</a>
                        <a href="{{ route('login') }}" type="button" class="btn btn-light rounded-pill me-2">Authenticate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero End -->

<!-- Features start -->
<section class="section bg-light" id="features">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <h2 class="fw-bold">Our Features</h2>
                <p class="text-muted">Here are some of the features offered by {{ config('app.name') }}</p>
            </div>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-5 order-2 order-md-1 mt-md-0 mt-5">
                <h2 class="mb-4">Media privacy controls</h2>
                <p class="text-muted mb-5">You can take full control over how you share media such as screenshots, gifs online by
                using our provided global or per media permissions controls. You can set your media to public or to private and
                share media via temporary URL</p>
            </div>
            <div class="col-md-6 ms-md-auto order-1 order-md-2">
                <div class="position-relative">
                    <div class="ms-5 features-img">
                        <img src="{{ asset('svg/full_privacy.svg') }}" alt="" class="img-fluid d-block mx-auto rounded" />
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row align-items-center section pb-0">
            <div class="col-md-6">
                <div class="position-relative mb-md-0 mb-5">
                    <div class="me-5 features-img">
                        <img src="{{ asset('svg/short_link.svg') }}" alt="" class="img-fluid d-block mx-auto rounded" />
                    </div>
                </div>
            </div>
            <div class="col-md-5 ms-md-auto">
                <h2 class="mb-4">Sharing long URLS?</h2>
                <p class="text-muted mb-5">{{ config('app.name') }} has you covered. {{ config('app.name') }} provides full functionality
                to make any long URL short in a single click and it works with ShareX</p>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- Features end -->

<section class="section bg-gradient-primary">
    <div class="bg-overlay-img" style="background-image: url({{ asset('theme/images/demos.png') }});"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <h1 class="text-white mb-4">Take control over your media today!</h1>
                    <p class="text-white mb-5 font-size-16"></p>
                    <a href="{{ route('frontend.auth.request') }}" class="btn btn-lg btn-light">Request Invite</a>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- Cta end -->
@endsection
