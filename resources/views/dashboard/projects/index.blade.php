@extends('dashboard.layouts')

@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Projects</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                @if($projects->count())

                    <div class="card-body p-0">


                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <th style="width: 15%">
                                    Name
                                </th>
                                <th style="width: 20%">
                                    Creator
                                </th>
                                <th>
                                    Source
                                </th>
                                <th style="width: 15%">
                                    Stacks
                                </th>
                                <th style="width: 15%">
                                    Link
                                </th>
                                <th style="width: 8%" class="text-center">
                                    Order
                                </th>
                                <th style="width: 10%" class="text-center">
                                    Created
                                </th>
                                <th style="width: 20%;font-size: 1.2rem" class="text-right">
                                    <span class="text-purple font-weight-bold">Total: {{$projects->total()}}</span>

                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>
                                        #
                                    </td>
                                    <td>
                                        {{$project->name}}
                                    </td>
                                    <td>
                                        @if($project->creator)
                                            <img class="table-avatar" src="{{$project->creator->image}}">

                                            {{$project->creator->fullName}}
                                        @endif
                                    </td>
                                    <td class="project_progress">
                                        {{$project->source}}
                                    </td>
                                    <td>
                                        @if($project->stacks)
                                            @foreach($project->stacks as $stack)
                                                <span class="badge badge-info ">{{$stack->name}}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="project_progress">
                                        <a href="{{$project->link}}" target="_blank">{{$project->link}}</a>
                                    </td>
                                    <td class="project_progress text-center">
                                        <a href="{{route('orders.edit', $project->order->id)}}"
                                           target="_blank">{{$project->order->name}}</a>
                                    </td>
                                    <td class="project_progress text-center">
                                        {{$project->created_at->format('d M,Y')}}
                                    </td>
                                    <td class="project-actions text-right">

                                        {{--                                        @can('view_order_and_orders_list')--}}
                                        {{--                                            <a class="btn btn-info btn-sm" href="{{route('orders.show',$order->id)}}">--}}
                                        {{--                                                <i class="fas fa-folder"></i>--}}
                                        {{--                                            </a>--}}
                                        {{--                                        @endcan--}}

                                        {{--                                        @can('order_create_update_delete')--}}

                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('projects.edit',$project->id)}}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>


                                        {{--                                            <form method="POST" action="{{ route('orders.destroy',  $order->id) }}"--}}
                                        {{--                                                  accept-charset="UTF-8"--}}
                                        {{--                                                  style="display:inline">--}}
                                        {{--                                                {{ method_field('DELETE') }}--}}
                                        {{--                                                {{ csrf_field() }}--}}
                                        {{--                                                <button type="submit" class="btn btn-danger btn-sm"--}}
                                        {{--                                                        title="Delete Permission"--}}
                                        {{--                                                        onclick="return confirm(&quot;Confirm delete?&quot;)">--}}
                                        {{--                                                    <i class="fas fa-trash"> </i>--}}
                                        {{--                                                </button>--}}
                                        {{--                                            </form>--}}
                                        {{--                                        @endcan--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $projects->appends($_GET)->links('vendor.pagination') !!}
                @else
                    <h1 class="text-center text-purple">No items</h1>
                @endif


            </div>
        </div>
    </section>
@endsection

