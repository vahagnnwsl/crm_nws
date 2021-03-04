@extends('dashboard.layouts')

@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Developers</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                @can('developer_create_update_delete')
                    <div class="card-header p-2">
                        <a class="btn btn-success btn-md float-right" href="{{route('developers.create')}}">
                            <i class="fas fa-plus-circle"></i>
                            Add
                        </a>
                    </div>
                @endcan

                @if($developers->count())
                    <div class="card-body p-0" style="display: block;">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>

                                <th style="width: 20%">
                                    Full name
                                </th>
                                <th style="width: 15%">
                                    Email
                                </th>
                                <th style="width: 10%">
                                    Position
                                </th>
                                <th style="width: 10%">
                                    Date
                                </th>

                                <th style="width: 15%" class="text-center">
                                    Status
                                </th>
                                <th style="width: 20%">
                                    Creator
                                </th>
                                <th style="width: 20%">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($developers as $developer)

                                <tr>
                                    <td>
                                        #
                                    </td>

                                    <td>
                                        {{$developer->fullName}}
                                    </td>
                                    <td>
                                        {{$developer->email}}
                                    </td>

                                    <td>
                                        {{$developer->position}}
                                    </td>
                                    <td>
                                        {{$developer->created_at->format('d.m.Y')}}
                                    </td>


                                    <td class="project-state">
                                        {{$developerStatuses[$developer->status]}}
                                    </td>
                                    <td>
                                        {{$developer->creator->fullName}}
                                    </td>
                                    <td class="project-actions text-right">

                                        @can('view_developer_and_developers_list')
                                           <a class="btn btn-primary btn-sm"
                                              href="{{route('developers.show',$developer->id)}}">
                                               <i class="fas fa-folder"></i>
                                           </a>
                                        @endcan

                                        @can('developer_create_update_delete')
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('developers.edit',$developer->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('developers.destroy',  $developer->id) }}"
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
                    {!! $developers->links('vendor.pagination') !!}

                @else
                    <h1 class="text-center text-purple">No items</h1>
                @endif

            </div>

        </div>

    </section>
@endsection



