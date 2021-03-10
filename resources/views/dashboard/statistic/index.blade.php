@extends('dashboard.layouts')
@push('css')

@endpush
@section('sub_content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card w-100">
                    <div class="card-header">
                        <h1 class="text-purple text-left">Statistic</h1>

                    </div>
                    <div class="card-body">

                         <div class="row">
                             <div class="col-md-12">
                                 <div class="card card-purple">
                                     <div class="card-header">
                                         <h3 class="card-title">All orders</h3>
                                     </div>
                                     <div class="card-body">
                                         <chart-users-order-statistic-all-time :data="{{json_encode($getUsersOrdersByAllTime)}}"></chart-users-order-statistic-all-time>
                                     </div>

                                 </div>
                             </div>

                             <div class="col-md-12">
                                 <div class="card card-info">
                                     <div class="card-header">
                                         <h3 class="card-title">All orders by month</h3>
                                     </div>
                                     <div class="card-body">
                                         <chart-user-order-statistic-by-month :data="{{json_encode($getUsersOrdersGroupMonth)}}"></chart-user-order-statistic-by-month>
                                     </div>

                                 </div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>
    <script src="/components/chart-users-order-statistic-all-time.js"></script>
    <script src="/components/chart-user-order-statistic-by-month.js"></script>

@endpush
