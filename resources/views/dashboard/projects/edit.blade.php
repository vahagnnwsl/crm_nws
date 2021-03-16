@extends('dashboard.layouts')
@push('css')

    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
@endpush
@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit project
                        <span class="text-purple">{{$project->name}}</span>

                        <a href="{{route('orders.edit', $project->order->id)}}"
                           target="_blank">Order: {{$project->order->hash}}</a>
                    </h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header p-2">
                    <a class="btn btn-primary btn-md float-right" id="um" href="{{route('projects.index')}}">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                        Back
                    </a>
                </div>

                <div class="card-body p-2 row">


                    <div class="col-md-6">
                        <form action="{{route('projects.update',$project->id)}}" method="POST">
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
                                                   value="{{$project->name}}">
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
                                                        value="{{$agent->id}}" {{$project->agent_id===$agent->id?'selected':''}}>{{$agent->fullName}}</option>
                                                @endforeach
                                            </select>
                                            @error('agent_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="expert_id">Expert </label>
                                            <select class="form-control" id="expert_id" name="expert_id">
                                                <option disabled selected>Select one</option>
                                                @foreach($developers as $developer)
                                                    <option
                                                        value="{{$developer->id}}" {{$project->expert_id === $developer->id ?' selected': ''}}>{{$developer->fullName}}</option>
                                                @endforeach
                                            </select>
                                            @error('expert_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="developer_id">Developer </label>
                                            <select class="form-control" id="developer_id" name="developer_id">
                                                <option disabled selected>Select one</option>
                                                @foreach($developers as $developer)
                                                    <option
                                                        value="{{$developer->id}}" {{$project->developer_id === $developer->id ?' selected': ''}}>{{$developer->fullName}}</option>
                                                @endforeach
                                            </select>
                                            @error('developer_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="team_lid_id">Team lid </label>
                                            <select class="form-control" id="team_lid_id" name="team_lid_id">
                                                <option disabled selected>Select one</option>
                                                @foreach($developers as $developer)
                                                    <option
                                                        value="{{$developer->id}}" {{$project->team_lid_id === $developer->id?'selected':''}}>{{$developer->fullName}}</option>
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
                                                        value="{{$source}}" {{$project->source === $source?'selected':''}}>{{$source}}</option>
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
                                                   value="{{$project->link}}">
                                            @error('link')
                                            <span class="invalid-feedback d-block" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="stacks">Stacks *</label>
                                            <select class="select2" style="width: 100%;" name="stacks[]" id="stacks"
                                                    multiple="multiple">

                                                @foreach($project->stacks as $stack)
                                                    <option value="{{$stack->id}}" selected>{{$stack->name}}</option>
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
                                                      name="description">{{$project->description}}</textarea>
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
                        <project-payments :project="{{json_encode($project)}}"  :rates="{{json_encode($project->rates)}}" :currencies="{{json_encode($currencies)}}"></project-payments>
                        <project-rates :project="{{json_encode($project)}}" :rates="{{json_encode($project->rates)}}" :currencies="{{json_encode($currencies)}}"></project-rates>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="/plugins/select2/js/select2.full.min.js"></script>

    <script src="/components/project-payments.js"></script>
    <script src="/components/project-rates.js"></script>

    <script>

        $(function () {
            $("input[name='currency']").click(function () {
                $(this).parent().parent().parent().parent().find('.currency_show_btn').html($(this).next().html())
            })

            $('.select2').select2({
                multiple: true,
                data: @json($stacks)
            })
        });
    </script>

@endpush
