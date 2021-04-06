@extends('dashboard.layouts')

@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header p-2">
                    @can('invite_user')
                        <a class="btn btn-success btn-md float-right" id="um" href="#" data-toggle="modal"
                           data-target="#user__create">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                    @endcan
                </div>
                <div class="card-body p-0" style="display: block;">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">
                                #
                            </th>
                            <th style="width: 1%">
                                Avatar
                            </th>
                            <th style="width: 20%">
                                Full name
                            </th>
                            <th style="width: 15%">
                                Email
                            </th>
                            <th style="width: 20%">
                                Role
                            </th>
                            <th>
                                Join
                            </th>
                            <th style="width: 8%" class="text-center">
                                Status
                            </th>
                            <th style="width: 20%">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)

{{--                            <tr  @if($user->id === \Illuminate\Support\Facades\Auth::id()) style="pointer-events: none;background-color: lightgrey"@endif>--}}
                                <tr>
                                <td>
                                    #
                                </td>
                                <td>
                                    <img class="table-avatar" src="{{$user->image}}">
                                </td>
                                <td>
                                    {{$user['full_name']}}
                                </td>
                                <td>
                                    {{$user['email']}}
                                </td>

                                <td>
                                    <p class="text-muted ">
                                        @foreach($user->roles as $role)
                                            <i class="{{$role->icon}}" title="{{$role->name}}"> {{$role->name}}</i>
                                        @endforeach
                                    </p>
                                </td>

                                <td>
                                    {{$user['created_at']->format('Y-m-d')}}
                                </td>
                                <td class="project-state">
                                    @if($user['status'])
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="project-actions text-right">

{{--                                    <a class="btn btn-default btn-sm" href="{{route('users.linkedin',$user->id)}}">--}}
{{--                                        <i class="fab fa-linkedin">--}}
{{--                                        </i>--}}
{{--                                    </a>--}}

                                    @can('view_user_and_users_list')
                                        @if($user->is_accepted_invitation)
                                            <a class="btn btn-primary btn-sm" href="{{route('users.show',$user->id)}}">
                                                <i class="fas fa-folder">
                                                </i>

                                            </a>
                                        @endif
                                    @endcan

                                    @can('user_edit_delete_update')
                                        @if($user->is_accepted_invitation)
                                            <a class="btn btn-info btn-sm" href="{{route('users.edit',$user->id)}}">
                                                <i class="fas fa-pencil-alt">
                                                </i>

                                            </a>
                                        @endif
                                    @endcan

                                    @can('login_via_anther_user')
                                        @if($user->is_accepted_invitation)
                                            <a class="btn btn-success btn-sm" href="{{route('users.login',$user->id)}}">
                                                <i class="fas fa-sign-in-alt">
                                                </i>

                                            </a>
                                        @endif
                                    @endcan

                                    @can('invite_user')
                                        @if(!$user->is_accepted_invitation)
                                            <a class="btn btn-warning btn-sm"
                                               href="{{route('users.resend-invitation',$user->id)}}">
                                                <i class="fas fa-envelope">
                                                </i>

                                            </a>
                                        @endif
                                    @endcan

                                    @can('user_edit_delete_update')
                                        <form method="POST" action="{{ route('users.destroy',  $user->id) }}"
                                              accept-charset="UTF-8"
                                              style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    title="Delete Permission"
                                                    onclick="return confirm(&quot;Confirm delete?&quot;)">
                                                <i class="fas fa-trash"> </i>
                                            </button>
                                        </form>
                                    @endcan

                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                </div>
                {!! $users->links('vendor.pagination') !!}


            </div>

        </div>
        <user-crate-component :roles="{{json_encode($roles)}}"></user-crate-component>

    </section>
@endsection


@push('js')

    <script src="/components/user-crate.js"></script>

@endpush
