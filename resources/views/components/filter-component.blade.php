
@push('css')
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
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
                            <select id="attr_{{$attr['name']}}" class="form-control select2" name="{{$attr['name']}}" multiple="multiple" data-placeholder="Select something">
                                @foreach($attr['options'] as $key=>$name)
                                    <option value="{{$key}}">{{$name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                @endforeach

                <div class="col-md-12">
                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-search"></i> </button>
                </div>
            </div>
        </form>

    </div>
</div>
@push('js')
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script>

        $(function () {

            $('.select2').select2({
                multiple: true,
            })
        });
    </script>
@endpush
