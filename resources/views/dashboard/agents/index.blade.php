@extends('dashboard.layouts')

@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Agents</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                @can('agent_create_update_delete')
                    <div class="card-header p-2">
                        <a class="btn btn-success btn-md float-right" id="um" href="{{route('agents.create')}}">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                    </div>
                @endcan

                @if($agents->count())
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <th style="width: 15%">
                                    Full name
                                </th>
                                <th style="width: 20%">
                                    Phone
                                </th>
                                <th>
                                    Email
                                </th>
                                <th style="width: 20%">
                                    Creator
                                </th>

                                <th style="width: 20%">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($agents as $agent)
                                <tr>
                                    <td>
                                        #
                                    </td>
                                    <td>
                                        {{$agent->fullName}}
                                    </td>
                                    <td>
                                        {{$agent->phone}}
                                    </td>
                                    <td>
                                        {{$agent->email}}
                                    </td>
                                    <td>
                                        @if($agent->creator)
                                            <img class="table-avatar" src="{{$agent->creator->image}}">

                                            {{$agent->creator->fullName}}
                                        @endif
                                    </td>


                                    <td class="project-actions text-right">
                                        @can('agent_create_update_delete')
                                            <a class="btn btn-primary btn-sm"
                                               href="{{route('agents.edit',$agent->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <form method="POST" action="{{ route('agents.destroy',  $agent->id) }}"
                                                  accept-charset="UTF-8"
                                                  style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        title="Delete Permission"
                                                        onclick="return confirm(&quot;Confirm delete?&quot;)">
                                                    <i class="fas fa-trash"> </i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <h1 class="text-center text-purple">No items</h1>
                @endif
            </div>
        </div>
    </section>
@endsection

