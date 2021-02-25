<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">NWS LAB</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{\Illuminate\Support\Facades\Auth::user()->image}}" class="img-circle elevation-3" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('account.profile')}}" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->fullName}}</a>
                <p class="text-white mt-2">
                    @foreach(\Illuminate\Support\Facades\Auth::user()->roles as $role)
                        <i class="{{$role->icon}}" title="{{$role->name}}"> {{$role->name}}</i>
                    @endforeach
                </p>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                @can('view_permissions_list')
                    <li class="nav-item ">
                        <a href="{{route('permissions.index')}}"
                           class="nav-link {{request()->is('dashboard/permissions*') ?'active':''}}">
                            <i class=" fas fa-user-tag nav-icon"></i>
                            <p>Permissions</p>
                        </a>
                    </li>
                @endcan

                @can('view_roles_list')
                    <li class="nav-item">
                        <a href="{{route('roles.index')}}"
                           class="nav-link {{request()->is('dashboard/roles*') ?'active':''}}">
                            <i class=" fas fa-user-tag nav-icon"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                @endcan

                @can('view_users_list')
                <li class="nav-item">
                    <a href="{{route('users.index')}}"
                       class="nav-link {{request()->is('dashboard/users*') ?'active':''}}">
                        <i class=" fas fa-user-alt nav-icon"></i>
                        <p>Users</p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
