@extends('adminlte::page')

@section('title', env('APP_NAME') . ' - View User')

@section('content_header')
    <h1>View User {{ $user->name }}</h1>
@stop

@section('content')

    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#information" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#roles" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#permissions" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Permissions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#images" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Images</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#short" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Short URLs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#activity" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Activity</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">

                <!-- User Information -->
                <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    <h4>User Infomration</h4>
                    <hr>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="reg_date">Registered</label>
                        <input type="text" id="reg_date" name="email" value="{{ $user->created_at->diffForHumans() }}" readonly class="form-control">
                    </div>
                </div> <!-- User Information -->

                <!-- User Roles -->
                <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <h4>User Roles</h4>
                    <hr>
                    <table id="roles-list" class="table table-striped table-bordered dt-responsive" style="width:100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Public Name</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->description }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Public Name</th>
                            <th>Description</th>
                        </tr>
                        </tfoot>
                    </table>
                </div> <!-- ./ User Roles -->

                <!-- User Permissions -->
                <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <h4>User permissions</h4>
                    <hr>
                    <table id="permissions-list" class="table table-striped table-bordered dt-responsive" style="width:100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Public Name</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->allPermissions() as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->display_name }}</td>
                                <td>{{ $permission->description }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Public Name</th>
                            <th>Description</th>
                        </tr>
                        </tfoot>
                    </table>
                </div> <!-- User Permissions -->

                <!-- User Images -->
                <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                    <h4>User Uploaded Images</h4>
                    <hr>
                    <table id="user-images" class="table table-striped table-bordered dt-responsive" style="width:100%">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Uploaded</th>
                            <th>Visibility</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->image as $img)
                            <tr>
                                <td>
                                    <a href="{{ AWSImage::generateTempLink($img->image_name, 5) }}" data-toggle="lightbox" data-title="{{ $img->image_name }}">
                                        {{ $img->image_name }}
                                    </a>
                                </td>
                                <td>{{ $img->created_at->diffForHumans() }}</td>
                                <td>
                                    <i class="text-success fas fa-{{ AWSImage::getFileVisibility($img->id) === 'public' ? 'globe' : 'lock' }}"
                                       title="{{ AWSImage::getFileVisibility($img->id) === 'public' ? 'Public' : 'Private' }}"></i>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a
                                                data-text="Image {{ $img->image_name }} will be deleted permanently"
                                                class="dropdown-item delete-confirm"
                                                href="{{ route('admin.image.delete', $img->id) }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                    </table>
                </div> <!-- User Images -->

                <!-- User Short URLS -->
                <div class="tab-pane fade" id="short" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                    <h4>User Short URLs</h4>
                    <hr>
                    <table id="short-urls" class="table table-striped table-bordered dt-responsive" style="width:100%">
                        <thead>
                        <tr>
                            <th>Original Url</th>
                            <th>Short URL</th>
                            <th>Expiries At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->shorturl as $url)
                            <tr>
                                <td>
                                    <a href="{{ $url->original_url }}" target="_blank">{{ Str::limit($url->original_url, 50) }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('frontend.shorturl', $url->short_url_hash) }}" target="_blank">{{ route('frontend.shorturl', $url->short_url_hash) }}</a>
                                </td>
                                <td>
                                    {{ $url->expiries_at !== null  ? \Carbon\Carbon::parse($url->expiries_at)->diffForHumans() : 'Never Expiries' }}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a
                                                data-text="Short URL {{ route('frontend.shorturl', $url->short_url_hash) }} will be deleted permanently!"
                                                class="dropdown-item delete-confirm"
                                                href="{{ route('admin.user.del.shorturl', $url->id) }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Original Url</th>
                            <th>Short URL</th>
                            <th>Expiries At</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                    </table>
                </div> <!-- ./ User Short URLS -->

                <!-- User Activity -->
                <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                    <h4>User Short URLs</h4>
                    <hr>
                    <table id="user-activity" class="table table-striped table-bordered dt-responsive" style="width:100%">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Activity</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->activity as $activity)
                            <tr>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $activity->description }}
                                </td>
                                <td>
                                    {{ $activity->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item delete-confirm" data-text="This user activity will be deleted permamently" href="#"><i class="fas fa-trash"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Username</th>
                            <th>Activity</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                    </table>
                </div> <!-- ./ User Activity -->
            </div>
        </div>
        <!-- /.card -->
    </div>
@stop


@section('js')
    <script>
        $(document).ready(function() {
            $('#user-images, #short-urls, #permissions-list, #roles-list, #user-activity').DataTable({
                "searching": true
            });
        } );
    </script>

    <script>
        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    </script>
