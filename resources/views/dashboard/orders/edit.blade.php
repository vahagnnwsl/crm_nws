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
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Persons</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#order__person">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <order-person-component></order-person-component>
    </section>
@endsection
@push('js')
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/components/order-person.js"></script>

    <script>

        $(document).ready(function () {
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
@endpush
