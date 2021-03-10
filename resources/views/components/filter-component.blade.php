@push('css')
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">

@endpush
<div class="card card-info p-2" data-select2-id="32">
    <div class="card-header">
        <h3 class="card-title">Filter</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>

        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body" style="display: block;" data-select2-id="31">
        <form method="GET" action="{{url(request()->path())}}">
            <div class="row">
                @foreach($filterAttrs as $attr)
                    <div class="col-md-3">
                        <label for="attr_{{$attr['name']}}">{{$attr['title']}}</label>
                        @if($attr['type'] === 'select')
                            <select id="attr_{{$attr['name']}}" class="form-control select2" name="{{$attr['name']}}"
                                    multiple="multiple" data-placeholder="Select something">
                                @foreach($attr['options'] as $item)
                                    <option
                                        @if(request()->get($attr['request_name']) && count(request()->get($attr['request_name'])) && in_array($item['id'],request()->get($attr['request_name']))) selected
                                        @endif value="{{$item['id']}}">{{$item['text']}}</option>
                                @endforeach
                            </select>
                        @elseif($attr['type'] === 'date_range')
                            <div class="form-group">

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                          </span>
                                    </div>

                                    <input type="text" class="form-control float-right date_range" id="date_range"
                                           name="{{$attr['name']}}" value="{{request()->get($attr['name'])}}">
                                </div>
                            </div>
                        @elseif($attr['type'] === 'input_text')
                            <input type="text" class="form-control" name="{{$attr['name']}}" id="attr_{{$attr['name']}}"
                                   value="{{request()->get($attr['name'])}}">
                        @endif
                    </div>
                @endforeach

                <div class="col-md-12">
                    <div class="btn-group btn-group-sm float-right">
                        <a href="{{url(request()->path())}}" class="btn btn-default float-right mr-1">Clear</a>
                        <button type="submit" class="btn btn-info float-right"><i class="fa fa-search"></i></button>

                    </div>


                </div>
            </div>
        </form>

    </div>
</div>
@push('js')
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>

    <script src="/plugins/daterangepicker/daterangepicker.js"></script>


    <script>

        $(function () {


            $('.date_range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                },
            });

            $('.date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('.date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });


            $('.select2').select2({
                multiple: true,
            })

        });
    </script>
@endpush
