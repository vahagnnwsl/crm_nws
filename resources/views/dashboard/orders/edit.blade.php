@extends('dashboard.layouts')
@push('css')

    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
@endpush
@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit order <span class="text-blue">{{$order->hash}}</span></h1>
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
                        <form action="{{route('orders.update',$order->id)}}" method="POST">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="row">
                                <div class="card card-primary w-100">
                                    <div class="card-header">
                                        <h3 class="card-title">General</h3>
                                    </div>
                                    <div class="card-body" style="display: block;">
                                        <div class="form-group">
                                            <label for="inputName">Name *</label>
                                            <input type="text" id="inputName" class="form-control" name="name"
                                                   value="{{$order->name}}">
                                            @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="agent">Agent *</label>
                                            <select class="form-control" id="agent" name="agent_id">
                                                <option disabled selected>Select one</option>
                                                @foreach($agents as $agent)
                                                    <option
                                                        value="{{$agent->id}}" {{$order->agent_id===$agent->id?'selected':''}}>{{$agent->fullName}}</option>
                                                @endforeach
                                            </select>
                                            @error('agent_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="sources">Source *</label>
                                            <select class="form-control" id="sources" name="source">
                                                <option disabled selected>Select one</option>
                                                @foreach($sources as $source)
                                                    <option
                                                        value="{{$source}}" {{$order->source === $source?'selected':''}}>{{$source}}</option>
                                                @endforeach
                                            </select>
                                            @error('source')
                                            <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="link">Link *</label>
                                            <input type="url" id="link" class="form-control" name="link"
                                                   value="{{$order->link}}">
                                            @error('link')
                                            <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group input-group-lg mb-3">
                                                <div class="input-group-prepend">
                                                    <button type="button"
                                                            class="btn btn-dark dropdown-toggle currency_show_btn"
                                                            data-toggle="dropdown" aria-expanded="false"
                                                            style="background-color: grey;border-radius: 0;border-color: grey">
                                                        {{$order->currency ??'Currency'}}
                                                    </button>
                                                    <ul class="dropdown-menu" style="">
                                                        @foreach($currencies as $currency)
                                                            <li class="dropdown-item">
                                                                <div class="form-check">
                                                                    <input class="form-check-input"
                                                                           id="currency__{{$currency->label}}"
                                                                           type="radio" name="currency"
                                                                           {{$order->currency === $currency->label ?'checked':'' }} value="{{$currency->label}}">
                                                                    <label class="form-check-label"
                                                                           for="currency__{{$currency->label}}">
                                                                        <i class="{{$currency->icon}}"></i>
                                                                        {{$currency->label}}

                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <!-- /btn-group -->
                                                <input type="number" class="form-control" name="budget"
                                                       placeholder="Budget" value="{{$order->budget}}">
                                                @error('budget')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                @error('currency')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>


                                        </div>


                                        <div class="form-group">
                                            <label for="stacks">Stacks *</label>
                                            <select class="select2" style="width: 100%;" name="stacks[]" id="stacks"
                                                    multiple="multiple">

                                                @foreach($order->stacks as $oldStacks)
                                                    <option value="{{$oldStacks}}" selected>{{$oldStacks}}</option>
                                                @endforeach
                                            </select>
                                            @error('stacks')
                                            <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Description </label>
                                            <textarea id="inputDescription" class="form-control" rows="4"
                                                      name="description">{{$order->description}}</textarea>
                                            @error('description')
                                            <span class="invalid-feedback d-block" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success float-right"><i
                                            class="fa fa-check-circle"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        @can('order_update_status')
                            <div class="row pl-2 pr-2">
                                <div class="card card-purple w-100 collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">Change status</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>


                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="agent">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                @foreach($statuses as $key => $status)
                                                    <option
                                                        value="{{$key}}" {{$order->status===$key?'selected':''}}>{{$status}}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror


                                        </div>
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea class="form-control" name="message" id="message" rows="2"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success float-right mb-2"><i
                                                    class="fa fa-check-circle"></i> Submit
                                            </button>

                                        </div>

                                        <div class="form-group mt-2">

                                            <div class="row w-100" style="max-height: 600px;overflow-y: auto">
                                                <div class="col-12 p-3 border ">
                                                    <div class="post">
                                                        <div class="user-block">
                                                            <img class="img-circle img-bordered-sm" src="/dist/img/user1-128x128.jpg" alt="user image">
                                                            <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                        </span>
                                                            <span class="description">Shared publicly - 7:45 PM today</span>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <p>
                                                            Lorem ipsum represents a long-held tradition for designers,
                                                            typographers and the like. Some people hate it and argue for
                                                            its demise, but others ignore.
                                                        </p>

                                                        <p>
                                                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                                                        </p>
                                                    </div>
                                                    <div class="post">
                                                        <div class="user-block">
                                                            <img class="img-circle img-bordered-sm" src="/dist/img/user1-128x128.jpg" alt="user image">
                                                            <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                        </span>
                                                            <span class="description">Shared publicly - 5 days ago</span>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <p>
                                                            Lorem ipsum represents a long-held tradition for designers,
                                                            typographers and the like. Some people hate it and argue for
                                                            its demise, but others ignore.
                                                        </p>

                                                        <p>
                                                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v1</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endcan

                        @can('order_person_create_update_delete')
                            <div class="row pl-2 pr-2">
                                <div class="card card-secondary w-100">
                                    <div class="card-header">
                                        <h3 class="card-title">People</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-toggle="modal"
                                                    data-target="#order__person">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>


                                    <div class="card-body">
                                        <table class="table table-striped projects">

                                            <tbody>
                                            @foreach($order->people as $person)
                                                <tr>
                                                    <td>
                                                        {{$person->fullName}}
                                                    </td>

                                                    <td>
                                                        {{$person->created_at->format('Y-m-d')}}
                                                    </td>
                                                    <td class="project-actions text-right">
                                                        <a data-id="{{$person->id}}" href="#"

                                                           class="btn btn-info btn-sm edit-person-btn">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        @endcan
                    </div>

                </div>
            </div>
        </div>
        <order-person-component :order="{{$order}}"></order-person-component>
    </section>
@endsection
@push('js')
    <script src="/plugins/select2/js/select2.full.min.js"></script>

    @can('order_person_create_update_delete')
        <script src="/components/order-person.js"></script>

        <script>


            $(document).ready(function () {

                $('.edit-person-btn').click(function () {
                    $(document).trigger('order_person_id.update', $(this).attr('data-id'));
                    $('#order__person').modal('show');
                })

                $("input[name='currency']").click(function () {
                    $('.currency_show_btn').html($(this).next().html())
                })
            })


            $(function () {

                $('.select2').select2({
                    multiple: true,
                    data: @json($stacks)
                })
            });
        </script>
    @endcan
@endpush
