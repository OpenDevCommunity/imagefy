@extends('adminlte::page')

@section('title', config('app.name') . ' - Administration Dashboard')

@section('content_header')
    <h1>{{ config('app.name') }} Dashboard</h1>
@stop

@section('content')

    <div class="conatiner">
        <!-- Statistics -->

        <div class="row">

            <!-- Statistic Item -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1>{{ $totalUsers }}</h1>
                        <p class="text-muted">Total Users</p>
                    </div>
                </div>
            </div>
            <!-- ./ Statistic Item -->


            <!-- Statistic Item -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1>{{ $totalImages }}</h1>
                        <p class="text-muted">Total Images</p>
                    </div>
                </div>
            </div>
            <!-- ./ Statistic Item -->


            <!-- Statistic Item -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1>0</h1>
                        <p class="text-muted">Private Images</p>
                    </div>
                </div>
            </div>
            <!-- ./ Statistic Item -->


            <!-- Statistic Item -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1>{{ $totalShortURLs }}</h1>
                        <p class="text-muted">Short URLS</p>
                    </div>
                </div>
            </div>
            <!-- ./ Statistic Item -->

        </div>

        <!-- ./ Statistics -->


        <section class="mt-3">
            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-success btn-sm float-right">View All</a>
                            <h5>Recent Users</h5>
                            <span class="text-muted">Recently registered users (5)</span>
                            <hr>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">email</th>
                                        <th scope="col">Registered</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recentUsers as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td><p>{{ $user->email }}</p></td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cogs"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="{{ route('admin.users.show', $user->id) }}" class="dropdown-item" title="Edit Image">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="dropdown-item" title="Edit Image">
                                                            <i class="fas fa-pencil-alt"></i> Edit
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>Recent Events</h5>
                            <span class="text-muted">Recently recorded events (5)</span>
                            <hr>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Event Description</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recentEvents as $event)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.users.show', Helper::getUserById($event->causer_id)->id) }}">{{ Helper::getUserById($event->causer_id)->name }}</a>
                                            </td>
                                            <td>{{ $event->description }}</td>
                                            <td>{{ $event->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@stop
