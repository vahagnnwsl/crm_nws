@extends('dashboard.layouts')

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
                                            <img class="profile-user-img img-fluid img-circle"
                                                 src="{{$user->image}}" alt="User profile picture">
                                        </div>

                                        <h3 class="profile-username text-center">{{$user->full_name}}</h3>

                                        <p class="text-muted text-center">
                                            @foreach($user->roles as $role)
                                                <i class="{{$role->icon}}" title="{{$role->name}}"> {{$role->name}}</i>
                                            @endforeach
                                        </p>

                                        <p class="text-muted text-center"><small class="text-blue">
                                                Join
                                                as:</small>
                                            {{$user->created_at}}</p>


                                    </div>


                                </div>

                            </div>
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#settings"
                                                                    data-toggle="tab">Settings</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="settings">
                                                <form class="form-horizontal" method="POST" action="{{route('users.update',$user->id)}}">
                                                    <input name="_method" type="hidden" value="PUT">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">First
                                                            name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="inputName"
                                                                   placeholder="First name" value="{{$user->first_name}}" name="first_name">
                                                            @error('first_name')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputLatName" class="col-sm-2 col-form-label">Last
                                                            name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="inputLatName"
                                                                   placeholder="Last name" value="{{$user->last_name}}" name="last_name">
                                                            @error('last_name')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail"
                                                               class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control" id="inputEmail"
                                                                   placeholder="Email" value="{{$user->email}}" name="email">
                                                            @error('email')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputRoles"
                                                               class="col-sm-2 col-form-label">Roles</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="role">
                                                                @foreach($roles as $role)
                                                                    <option value="{{$role->id}}" {{count($user->roles) && $user->roles[0]->id === $role->id?'selected':''}}> {{$role->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('role')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputRoles"
                                                               class="col-sm-2 col-form-label">Status</label>
                                                        <div class="col-md-10">
                                                            <div class="form-check">
                                                                <input class="form-check-input" id="active__status" type="radio" name="status" {{$user->status ===1?'checked':''}} value="1">
                                                                <label class="form-check-label" for="active__status">Active</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input"   id="inactive__status"type="radio" name="status" {{$user->status===0?'checked':''}} value="0">
                                                                <label class="form-check-label" for="inactive__status">Inactive</label>
                                                            </div>
                                                        </div>
                                                        @error('status')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" class="btn btn-danger">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>


            </div>

        </div>
    </section>
@endsection
