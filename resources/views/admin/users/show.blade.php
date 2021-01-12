@extends('adminlte::page')

@section('title', 'MD Share - View User')

@section('content_header')
    <h1>View User {{ $user->name }}</h1>
@stop

@section('content')

    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
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
                        <input type="text" id="red_date" name="email" value="{{ $user->created_at->diffForHumans() }}" readonly class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
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
            </div>
        </div>

        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>User Uploaded Images</h4>
                    <hr>
                    <table id="images" class="table table-striped table-bordered" style="width:100%">
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
                                    <a href="{{ AWSImage::generateTempLink($img->image_name, 5) }}" data-toggle="lightbox" data-gallery="gallery">
                                        {{ $img->image_name }}
                                    </a>
                                </td>
                                <td>{{ $img->created_at->diffForHumans() }}</td>
                                <td>
                                    <i class="text-success fas fa-{{ AWSImage::getFileVisibility($img->id) === 'public' ? 'globe' : 'lock' }}"
                                       title="{{ AWSImage::getFileVisibility($img->id) === 'public' ? 'Public' : 'Private' }}"></i>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
            </div>
        </div>

    </div>

@stop


@section('js')
    <script>
        $(document).ready(function() {
            $('#images').DataTable({
                "searching": true
            });
        } );
    </script>

    <script>
        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
@endsection
