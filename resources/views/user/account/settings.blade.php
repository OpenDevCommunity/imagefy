@extends('layouts.app')

@section('content')

    <div class="container">

         <!-- Connections -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Personal Information</h5>
                <br />

                <form action="#" method="POST">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success btn-block">Save Settings</button>
                    </div>

                </form>


            </div>
        </div>

        <!-- ./ Connections -->

    </div>

@endsection
