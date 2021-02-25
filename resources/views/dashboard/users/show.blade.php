@extends('dashboard.layouts')

<?php
$tab = 'timeline';

if (request()->get('tab') && in_array(request()->get('tab'), ['timeline', 'activities'])) {
    $tab = request()->get('tab');
}

?>

@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$user->email}}</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header p-2">
                    <a class="btn btn-primary btn-md float-right" href="{{route('users.index')}}">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                        Back
                    </a>

                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">

                                <!-- Profile Image -->
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" src="{{$user->image}}"
                                                 alt="User profile picture">
                                        </div>

                                        <h3 class="profile-username text-center">{{$user->full_name}}</h3>

                                        <p class="text-muted text-center">
                                            @foreach($user->roles as $role)
                                                <i class="{{$role->icon}}" title="{{$role->name}}"> {{$role->name}}</i>
                                            @endforeach
                                        </p>

                                        <p class="text-muted text-center"><small class="text-blue">Join
                                                as:</small> {{$user->created_at->format('Y-m-d')}}</p>


                                    </div>
                                </div>

                            </div>
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link {{$tab ==='timeline' ?'active':''}}" href="{{route('users.show',['id'=>$user->id,'tab'=>'timeline'])}}"
                                                                   >Timeline</a></li>
                                            <li class="nav-item"><a class="nav-link {{$tab ==='activities' ?'active':''}}" href="{{route('users.show',['id'=>$user->id,'tab'=>'activities'])}}"
                                                                    >Activity</a></li>

                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">

                                            @if($tab === 'timeline')
                                                <x-timeline :resource="$resource"></x-timeline>
                                            @else
                                                <x-activity :resource="$resource"></x-activity>
                                            @endif
                                        </div>
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
    <script>

        $('pre').each(function (){
            if ($(this).attr('data-json')){
                $(this).html( JSON.stringify(JSON.parse($(this).attr('data-json')), undefined, 2))
            }
        });
    </script>

@endpush
