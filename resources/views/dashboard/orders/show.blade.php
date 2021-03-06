@extends('dashboard.layouts')

@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Info order <span class="text-blue">{{$order->hash}}</span></h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header p-2">
                    <a class="btn btn-primary btn-md float-right" id="um" href="{{route('orders.index')}}">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                        Back
                    </a>
                </div>

                <div class="card-body p-2 row">

                    <div class="col-md-6">
                        <div class="row ">
                            <div class="card card-primary w-100">
                                <div class="card-header">
                                    <h3 class="card-title">General</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tbody>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Creator</strong></th>
                                                <td>{{$order->creator->fullName}}</td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Name</strong></th>
                                                <td>{{$order->name}}</td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Agent</strong></th>
                                                <td>{{$order->agent->fullName}}</td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Developer</strong></th>
                                                <td>{{$order->developer->fullName}}</td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Team lead</strong></th>
                                                <td>{{$order->teamLead->fullName}}</td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Source </strong></th>
                                                <td>{{$order->source }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Link </strong></th>
                                                <td>{{$order->link }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Budget </strong></th>
                                                <td>{{$order->budget }} {{$order->currency }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Stacks </strong></th>
                                                <td>
                                                    @foreach($order->stacks as $stack)
                                                        {{$stack}}
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Description </strong></th>
                                                <td>
                                                    {{$order->description}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pl-0 w-25" scope="row"><strong>Created </strong></th>
                                                <td>
                                                    {{$order->created_at->format('d.m.Y H:s')}}
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card card-info w-100">
                                <div class="card-header">
                                    <h3 class="card-title">People</h3>
                                </div>
                                <div class="card-body row">
                                    @foreach($order->people as $person)
                                        <div class="col-6 col-sm-12 col-md-6 d-flex align-items-stretch flex-column">
                                            <div class="card bg-light d-flex flex-fill">
                                                <div class="card-header text-muted border-bottom-0">
                                                    <i class="fas fa-user-alt"></i>    {{$person->fullName}}
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="text-muted text-sm"><b>About: </b> {{$person->position ?? 'N/A'}}</p>
                                                            <ul class="ml-4 mb-0 fa-ul text-muted">


                                                                    <li class="small mt-1"><span class="fa-li">
                                                                        <i class="fas fa-lg fa-phone"></i>
                                                                    </span> {{$person->phone ?? 'N/A'}}
                                                                    </li>

                                                                    <li class="small mt-1"><span class="fa-li">
                                                                        <i class="fas fa-lg fa-envelope"></i>
                                                                    </span> {{$person->email?? 'N/A'}}
                                                                    </li>

                                                                    <li class="small mt-1"><span class="fa-li">
                                                                        <i class="fab fa-lg  fa-skype"></i>
                                                                    </span> {{$person->skype?? 'N/A'}}
                                                                    </li>



                                                                    <li class="small mt-1"><span class="fa-li">
                                                                        <i class="fab fa-lg fa-telegram"></i>
                                                                    </span> {{$person->telegram?? 'N/A'}}
                                                                    </li>

                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-purple">
                            <div class="card-header">
                                <h3 class="card-title">Status history</h3>
                            </div>
                            <div class="card-body">
                                @foreach($order->statusComments as $status)
                                    <div class="post" style="padding-bottom: 0!important;">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ $status->creator->image }}"
                                                 alt="user image">
                                            <span class="username">
                                                <a href="#">{{ $status->creator->fullName }}</a>
                                             </span>
                                            <span class="description">Change status to
                                                <span class="text-danger font-weight-bold"> {{ $status->status }}</span> -
                                                   {{ $status->created_at->format('d.m.Y H:S') }}
                                            </span>
                                        </div>

                                        <p style="font-size: 13px">{{ $status->comment }}</p>

                                        @if($status->file)
                                            <p>
                                                <a href="{{$status->file}}" target="_blank"
                                                   class="link-black text-sm"><i
                                                        class="fas fa-link mr-1"></i> Attachment</a>
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection
