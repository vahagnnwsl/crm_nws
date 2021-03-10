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

                    <form method="POST" action="{{route('orders.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">General</h3>
                                    </div>
                                    <div class="card-body" style="display: block;">
                                        <div class="form-group">
                                            <label for="inputName">Name *</label>
                                            <input type="text" id="inputName" class="form-control" name="name"
                                                   value="{{old('name')}}">
                                            @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="agent">Agent * </label>
                                            <select class="form-control" id="agent" name="agent_id">
                                                <option disabled selected>Select one</option>
                                                @foreach($agents as $agent)
                                                    <option value="{{$agent->id}}" {{old('agent_id') === $agent->id ? 'selected':''}}>{{$agent->fullName}}</option>
                                                @endforeach
                                            </select>
                                            @error('agent_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="developer_id">Developer  </label>
                                            <select class="form-control" id="developer_id" name="developer_id">
                                                <option disabled selected>Select one</option>
                                                @foreach($developers as $developer)
                                                    <option value="{{$developer->id}}" {{ old('developer_id') === $developer->id ?' selected': ''}}>{{$developer->fullName}}</option>
                                                @endforeach
                                            </select>
                                            @error('developer_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="expert_id">Expert  </label>
                                            <select class="form-control" id="expert_id" name="expert_id">
                                                <option disabled selected>Select one</option>
                                                @foreach($developers as $developer)
                                                    <option value="{{$developer->id}}" {{ old('expert_id') === $developer->id ?' selected': ''}}>{{$developer->fullName}}</option>
                                                @endforeach
                                            </select>
                                            @error('expert_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="team_lid_id">Team lid  </label>
                                            <select class="form-control" id="team_lid_id" name="team_lid_id">
                                                <option disabled selected>Select one</option>
                                                @foreach($developers as $developer)
                                                    <option
                                                        value="{{$developer->id}}" {{old('team_lid_id')===$developer->id?'selected':''}}>{{$developer->fullName}}</option>
                                                @endforeach
                                            </select>
                                            @error('team_lid_id')
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
                                                        value="{{$source}}" {{old('source')===$source?'selected':''}}>{{$source}}</option>
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
                                                   value="{{old('link')}}">
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
                                                        {{old('currency') ??'Currency'}}
                                                    </button>
                                                    <ul class="dropdown-menu" style="">
                                                        @foreach($currencies as $currency)
                                                            <li class="dropdown-item">
                                                                <div class="form-check">
                                                                    <input class="form-check-input"
                                                                           id="currency__{{$currency->label}}"
                                                                           type="radio" name="currency"
                                                                           {{old('currency') === $currency->label ?'checked':'' }} value="{{$currency->label}}">
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
                                                       placeholder="Budget" value="{{old('budget')}}">
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
                                            <select class="select2" style="width: 100%;" name="stacks[]" id="stacks"  multiple="multiple">

                                                @if(old('stacks'))
                                                    @foreach(getOldStacksForSelect2(old('stacks')) as $oldStacks)
                                                       <option value="{{$oldStacks['id']}}" selected>{{$oldStacks['text']}}</option>
                                                    @endforeach
                                                @endif
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
                                                      name="description">{{old('description')}}</textarea>
                                            @error('description')
                                            <span class="invalid-feedback d-block" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success float-right"><i
                                                    class="fa fa-check-circle"></i> Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="/plugins/select2/js/select2.full.min.js"></script>

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
