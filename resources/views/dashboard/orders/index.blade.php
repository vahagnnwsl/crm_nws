@extends('dashboard.layouts')

@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                @can('order_create_update_delete')
                    <div class="card-header p-2">
                        <a class="btn btn-success btn-md float-right" id="um" href="{{route('orders.create')}}">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                    </div>
                @endcan

                <x-filter-component :filterAttributes="$filterAttributes"/>

                @if($orders->count())

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
                                    Status
                                </th>
                                <th style="width: 10%" class="text-center">
                                    Created
                                </th>
                                <th style="width: 20%;font-size: 1.2rem" class="text-right">
                                    <span class="text-purple font-weight-bold">Total: {{$orders->total()}}</span>

                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        #
                                    </td>
                                    <td>
                                        {{$order->name}}
                                    </td>
                                    <td>
                                        @if($order->creator)
                                            <img class="table-avatar" src="{{$order->creator->image}}">

                                            {{$order->creator->fullName}}
                                        @endif
                                    </td>
                                    <td class="project_progress">
                                        {{$order->source}}
                                    </td>
                                    <td>
                                        @if($order->stacks)
                                            @foreach($order->stacks as $stack)
                                                <span class="badge badge-info ">{{$stack->name}}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="project_progress">
                                        <a href="{{$order->link}}" target="_blank">{{$order->link}}</a>
                                    </td>
                                    <td class="project_progress text-center">
                                        {{$statuses[$order->status]}}
                                    </td>
                                    <td class="project_progress text-center">
                                        {{$order->created_at->format('d M,Y')}}
                                    </td>
                                    <td class="project-actions text-right">

                                        @can('view_order_and_orders_list')
                                            <a class="btn btn-info btn-sm" href="{{route('orders.show',$order->id)}}">
                                                <i class="fas fa-folder"></i>
                                            </a>
                                        @endcan

                                        @can('order_create_update_delete')

                                            <a class="btn btn-primary btn-sm"
                                               href="{{route('orders.edit',$order->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>


                                            <form method="POST" action="{{ route('orders.destroy',  $order->id) }}"
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
                    {!! $orders->appends($_GET)->links('vendor.pagination') !!}
                @else
                    <h1 class="text-center text-purple">No items</h1>
                @endif
            </div>
        </div>
    </section>
@endsection

