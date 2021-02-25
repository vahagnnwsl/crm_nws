@extends('layouts.app')

@section('content')
    <div class="login-box">
        @if($user)
        <div class="login-logo">
            <a href="#"><b>NWS</b>LAB</a>
        </div>
        <!-- /.login-logo -->
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div>{{$error}}</div>
                @endforeach
            @endif
        <div class="card">

            <div class="card-body login-card-body">
                <p class="login-box-msg">Fill <span class="text-blue">{{$user->email}}</span>  to be start your session</p>

                <form action="{{ route('user-invitation',[$user->invitation_token,$user->email]) }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="first_name" value="{{old('first_name')}}" class="form-control" placeholder="First name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-alt"></span>
                            </div>
                        </div>

                        @error('first_name')
                        <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="last_name"  value="{{old('last_name')}}" class="form-control" placeholder="Last name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-alt"></span>
                            </div>
                        </div>

                        @error('last_name')
                        <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password_confirmation')
                        <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="row">

                        <button type="submit" class="btn btn-primary btn-block">Save</button>

                    </div>
                </form>


            </div>


        </div>
        @else
            <h1 class="text-danger font-weight-bold">Invalid link</h1>
        @endif
    </div>
@endsection

