@extends('layouts.app')

@section('content')

   <div class="container">

       <main role="main">
           <div class="jumbotron shadow-sm">
               <h1>Welcome to {{ config('app.name') }}</h1>
               <p class="py-3">
                   {{ config('app.name') }} is a private image sharing & URL shortener built for personal use. As this project is private and not available to general public you can still request
                   an invite to be sent to you. Once you receive your invite you can then create an account. Please note that not every invite request will be approved but
                   why not to give it a try.
               </p>

               <p><strong>Current Version: </strong> @version</p>
               <p><strong>Released: </strong> {{ \Carbon\Carbon::parse(Version::format('timestamp-full'))->fromNow() }}</p>

               <p class="text-danger">
                   This project is in early alpha which means that you might find some nasty bugs that can be reported in your dashboard.
               </p>
               <a class="btn btn-lg btn-primary mt-2" href="{{ route('frontend.auth.request') }}" role="button">Request Invite &raquo;</a>
           </div>
       </main>

   </div>

@endsection
