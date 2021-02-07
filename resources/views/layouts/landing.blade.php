<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} - Home Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Image sharing & URL shortener for ShareX" />
    <meta name="keywords" content="image, imagesharing, privacy" />
    <meta content="Open Dev Community" name="author" />
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('theme/images/favicon.ico') }}" />

    <!-- css -->
    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/css/style.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body data-spy="scroll" data-target="#navbar" data-offset="20">

<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>

    @yield('content')

<!-- Footer Start -->
<footer class="footer" style="background-image: url({{ asset('theme/images/footer-bg.png') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-5">
                    <p class="text-white-50 f-15 mb-0">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Open Dev Community Foundation, All Rights Reserved. Imagefy is a trademark™ of Open Dev Community Foundation.
                    </p>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</footer>
<!-- Footer End -->

<!-- javascript -->
<script src="{{ asset('theme/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('theme/js/smooth-scroll.polyfills.min.js') }}"></script>

<script src="https://unpkg.com/feather-icons"></script>

<!-- App Js -->
<script src="{{ asset('theme/js/app.js') }}"></script>
</body>

</html>
