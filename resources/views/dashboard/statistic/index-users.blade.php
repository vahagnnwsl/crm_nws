@extends('dashboard.layouts')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue2-datepicker@3.9.0/index.css">
@endpush
@section('sub_content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card w-100">
                    <div class="card-header">
                        <h1 class="text-purple text-left">Statistic users</h1>

                    </div>
                    <div class="card-body">

                        <div class="row">

                               <user-order></user-order>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/vue2-datepicker@3.9.0/index.min.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.13.1/lodash.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>
    <script src="https://unpkg.com/vuejs-datepicker/dist/locale/translations/fr.js"></script>

    <script src="/components/statistic/pie2-chart.js"></script>

    <script src="/components/statistic/user/user-order.js"></script>


@endpush

