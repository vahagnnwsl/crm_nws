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
                <div class="card-header p-2">
                    <a class="btn btn-success btn-md float-right" id="um" href="{{route('orders.create')}}">
                        <i class="fas fa-plus"></i>
                        Add
                    </a>
                </div>

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
                            <th style="width: 20%">
                                Stacks
                            </th>
                            <th>
                                Link
                            </th>
                            <th style="width: 8%" class="text-center">
                                Status
                            </th>
                            <th style="width: 20%">
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
                                        <span class="badge badge-info ">{{$stack}}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td class="project_progress">
                               <a href="{{$order->link}}" target="_blank">{{$order->link}}</a>
                            </td>
                            <td class="project_progress text-center">
                                {{$order->status}}
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{route('orders.edit',$order->id)}}">
                                    <i class="fas fa-folder"></i>
                                </a>

                                <a class="btn btn-info btn-sm" href="#">
                                    <i class="fas fa-pencil-alt">
                                    </i>

                                </a>
                                <a class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash">
                                    </i>

                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $orders->links('vendor.pagination') !!}

            </div>
        </div>
    </section>
@endsection
