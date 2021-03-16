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
                        <order-edit  :agents="{{json_encode($agents)}}"
                                      :developers="{{json_encode($developers)}}"
                                      :sources="{{json_encode($sources)}}"
                                      :stacks="{{json_encode($stacks)}}"
                                      :currencies="{{json_encode($currencies)}}"
                                      :order="{{json_encode($order)}}"
                        ></order-edit>
                    </div>
                    <div class="col-md-6">

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
                        @can('order_update_status')
                            <div class="row pl-2 pr-2">
                                <order-status :statuses="{{json_encode($statuses)}}" :order="{{json_encode($order)}}"></order-status>
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

    @can('order_update_status')
      <script src="/components/order/status.js"></script>
    @endcan
    @can('order_person_create_update_delete')
        <script src="/components/order/person.js"></script>
        <script src="/components/order/edit.js"></script>

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
                })
            });

        </script>
    @endcan
@endpush
