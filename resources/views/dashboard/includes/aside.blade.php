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

                @can('view_user_and_users_list')
                <li class="nav-item">
                    <a href="{{route('users.index')}}"
                       class="nav-link {{request()->is('dashboard/users*') ?'active':''}}">
                        <i class=" fas fa-user-alt nav-icon"></i>
                        <p>Users</p>
                    </a>
                </li>
                @endcan

                @can('view_order_and_orders_list')
                <li class="nav-item">
                    <a href="{{route('orders.index')}}"
                       class="nav-link {{request()->is('dashboard/orders*') ?'active':''}}">
                        <i class="fa fa-address-card nav-icon"></i>
                        <p>Orders</p>
                    </a>
                </li>
                @endcan
                <li class="nav-item">
                    <a href="{{route('projects.index')}}"
                       class="nav-link {{request()->is('dashboard/projects*') ?'active':''}}">
                        <i class="fa  fa-id-card nav-icon"></i>
                        <p>Projects</p>
                    </a>
                </li>

                @can('view_agent_and_agents_list')
                <li class="nav-item">
                    <a href="{{route('agents.index')}}"
                       class="nav-link {{request()->is('dashboard/agents*') ?'active':''}}">
                        <i class="fa fa-user-secret nav-icon"></i>
                        <p>Agents</p>
                    </a>
                </li>
                @endcan

                @can('view_developer_and_developers_list')
                <li class="nav-item">
                    <a href="{{route('developers.index')}}"
                       class="nav-link {{request()->is('dashboard/developers*') ?'active':''}}">
                        <i class="fab fa-dev nav-icon"></i>
                        <p>Developers</p>
                    </a>
                </li>
                @endcan

                <li class="nav-item  {{request()->is('dashboard/statistic*') ?'menu-is-opening menu-open':''}}">
                    <a href="#" class="nav-link  {{request()->is('dashboard/statistic*') ?'active':''}}">
                        <i class="nav-icon fa fa-chart-bar"></i>
                        <p>
                            Statistic
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{route('statistic.indexOrders')}}" class="nav-link {{request()->is('dashboard/statistic/orders*') ?'active':''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('statistic.indexUsers')}}" class="nav-link {{request()->is('dashboard/statistic/users*') ?'active':''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>

                    </ul>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
