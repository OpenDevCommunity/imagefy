@extends('adminlte::page')

@section('title', env('APP_NAME') . ' - Administration Errors Index')

@section('content_header')
    <h1>Error Log</h1>
@stop

@section('content')

    <div class="conatiner">
        <section class="mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="errors-list" class="table table-striped table-bordered dt-responsive" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Message</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($errors as $error)
                                    <tr>
                                        <td>{{ $error->code }}</td>
                                        <td>{{ Str::limit($error->message, 150) }}</td>
                                        <td>{{ $error->created_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cogs"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ route('admin.errors.show', $error->id) }}"><i class="fas fa-eye"></i> View</a>
                                                    <a class="dropdown-item delete-confirm" data-text="This error log will be permanently deleted" href="{{ route('admin.errors.delete', $error->id) }}"><i class="fas fa-trash"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Code</th>
                                    <th>Message</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@stop


@section('js')
    <script>
        $(document).ready(function() {
            $('#errors-list').DataTable({
                "searching": true
            });
        } );
    </script>

@endsection
