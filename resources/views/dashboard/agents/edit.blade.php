@extends('dashboard.layouts')
@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit agent <span class="text-blue">{{$agent->fullName}}</span></h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header p-2">
                    <a class="btn btn-primary btn-md float-right" id="um" href="{{route('agents.index')}}">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                        Back
                    </a>
                </div>

                <div class="card-body p-2">
                    <form method="POST" action="{{route('agents.update',$agent->id)}}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="person_first_name">First name</label>
                                    <input type="text" id="person_first_name" class="form-control" name="first_name" value="{{$agent->first_name}}">

                                    @error('first_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>



                                <div class="form-group">
                                    <label for="person_last_name">Last name</label>
                                    <input type="text" id="person_last_name" class="form-control" name="last_name" value="{{$agent->last_name}}">

                                    @error('last_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                    @enderror
                                </div>



                                <div class="form-group">
                                    <label for="person_email">E-mail</label>
                                    <input type="email" id="person_email" class="form-control" name="email" value="{{$agent->email}}">

                                    @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                </div>



                                <div class="form-group">
                                    <label for="person_telegram">Telegram</label>
                                    <input type="text" id="person_telegram" class="form-control" name="telegram" value="{{$agent->telegram}}">

                                    @error('telegram')
                                    <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                    @enderror
                                </div>



                                <div class="form-group">
                                    <label for="person_skype">Skype</label>
                                    <input type="text" id="person_skype" class="form-control" name="skype" value="{{$agent->skype}}">

                                    @error('skype')
                                    <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                         </span>
                                    @enderror
                                </div>



                                <div class="form-group">
                                    <label for="person_phone">Phone</label>
                                    <input type="text" id="person_phone" class="form-control"  name="phone" value="{{$agent->phone}}">

                                    @error('phone')
                                    <span class="invalid-feedback d-block" role="alert">
                                           <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>



                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success float-right"><i class="fa fa-check-circle"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
