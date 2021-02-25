@extends('dashboard.layouts')

@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Roles</h1>
                </div>


            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                @can('role_create_update_delete')
                    <div class="card-header p-2">
                        <a class="btn btn-success btn-sm float-right" href="#" data-toggle="modal"
                           data-target="#role__create">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>

                    </div>
                @endcan
                <div class="card-body p-2">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <th style="width: 20%">
                                    Name
                                </th>
                                <th style="width: 30%">
                                    Guard Name
                                </th>
                                <th>
                                    Created At
                                </th>
                                <th class="text-right">

                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <i style="width: 20px" class="{{$role->icon}} table-avatar"></i>
                                    </td>
                                    <td>
                                        {{$role->name}}
                                    </td>
                                    <td>
                                        {{$role->guard_name}}
                                    </td>
                                    <td>
                                        {{$role->created_at->format('Y-m-d')}}
                                    </td>

                                    <td class="project-actions text-right">
                                        @can('give_permission_to_role')
                                            <a class="btn btn-info btn-sm edit-btn" data-id="{{$role->id}}" href="#"
                                               data-toggle="modal" data-target="#role__permission">
                                                <i class="fas fa-pencil-alt"></i>
                                                Edit
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <script>

        </script>
    </section>

    @include('dashboard.modals.role-permission-modal')
    @include('dashboard.modals.create-role-modal')

@endsection

