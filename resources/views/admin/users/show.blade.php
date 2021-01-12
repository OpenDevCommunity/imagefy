@extends('adminlte::page')

@section('title', 'MD Share - View User')

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
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
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
                </div>
                <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <h4>User Roles</h4>
                    <hr>
                    {{ csrf_field() }}
                    @foreach($user->roles as $role)
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="roles[]" {{ $user->hasRole($role->name) ? 'checked' : '' }} disabled value="{{ $role->id }}" id="role-{{ $role->id }}">
                                <label for="role-{{ $role->id }}">
                                    {{ $role->name }} <small>({{ $role->description }})</small>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <h4>User permissions</h4>
                    <hr>
                    @foreach($user->allPermissions() as $permission)
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="roles[]" {{ $user->hasPermission($permission->name) ? 'checked' : '' }} disabled value="{{ $permission->id }}" id="role-{{ $permission->id }}">
                                <label for="role-{{ $permission->id }}">
                                    {{ $permission->name }} <small>({{ $permission->description }})</small>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                    <h4>User Uploaded Images</h4>
                    <hr>
                    <table id="user-images" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Uploaded</th>
                            <th>Visibility</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->images as $img)
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
                                    <!--<a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a> -->
                                    <a href="{{ route('admin.image.delete', $img->id) }}" class="btn btn-danger delete-confirm btn-sm"><i class="fas fa-trash"></i></a>
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
                </div>

                <div class="tab-pane fade" id="short" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                    <h4>User Short URLs</h4>
                    <hr>
                    <table id="short-urls" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Original Url</th>
                            <th>Short URL</th>
                            <th>Expiries At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->shorturls as $url)
                            <tr>
                                <td>
                                    <a href="{{ $url->original_url }}" target="_blank">{{ Str::limit($url->original_url, 50) }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('frontend.shorturl', $url->short_url_hash) }}" target="_blank">{{ route('frontend.shorturl', $url->short_url_hash) }}</a>
                                </td>
                                <td>
                                    {{ $url->expiried ? \Carbon\Carbon::parse($url->expities_at)->diffForHumans() : 'Expiried' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.user.del.shorturl', $url->id) }}" class="btn btn-danger btn-sm delete-confirm"><i class="fas fa-trash"></i></a>
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
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
@stop


@section('js')
    <script>
        $(document).ready(function() {
            $('#user-images').DataTable({
                "searching": true
            });
        } );
    </script>

    <script>
        $(document).ready(function() {
            $('#short-urls').DataTable({
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

    <script>
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This record and it`s details will be permanantly deleted!',
                showCancelButton: true,
                confirmButtonText: `I Understand`
            }).then((result) => {
                console.log(result);
                if (result.value) {
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
