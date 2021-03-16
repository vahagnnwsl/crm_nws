@extends('dashboard.layouts')
@push('css')

    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
@endpush
@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create order</h1>
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

                <div class="card-body p-2">

                   <div class="col-md-8 mx-auto">
                       <order-create :agents="{{json_encode($agents)}}"
                                     :developers="{{json_encode($developers)}}"
                                     :sources="{{json_encode($sources)}}"
                                     :stacks="{{json_encode($stacks)}}"
                                     :currencies="{{json_encode($currencies)}}"
                       ></order-create>
                   </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="/plugins/select2/js/select2.full.min.js"></script>

    <script src="/components/order/create.js"></script>

    <script>

        $(document).ready(function () {
            $("input[name='currency']").click(function () {
                $('.currency_show_btn').html($(this).next().html())
            })
            {{--$('.select2').select2({--}}
            {{--    multiple: true,--}}
            {{--    --}}{{--data: @json($stacks)--}}
            {{--})--}}
        })

    </script>
@endpush
