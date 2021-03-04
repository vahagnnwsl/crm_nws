@extends('dashboard.layouts')
@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create developer</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header p-2">
                    <a class="btn btn-primary btn-md float-right" id="um" href="{{route('developers.index')}}">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                        Back
                    </a>
                </div>

                <div class="card-body p-2">
                    <form method="POST" action="{{route('developers.store')}}"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mx-auto mt-2">

                               <div class="card  card-primary">
                                   <div class="card-header">
                                       <h3 class="card-title">General</h3>
                                   </div>
                                   <div class="card-body">
                                       <div class="form-group">
                                           <label for="agent">Position * </label>
                                           <select class="form-control" id="position" name="position">
                                               <option disabled selected>Select one</option>
                                               @foreach($developerPositions as $developerPosition)
                                                   <option
                                                       value="{{$developerPosition}}" {{old('position')===$developerPosition?'selected':''}}>{{$developerPosition}}</option>
                                               @endforeach
                                           </select>
                                           @error('position')
                                           <span class="invalid-feedback d-block" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                           @enderror
                                       </div>

                                       <div class="form-group">
                                           <label for="person_first_name">First name *</label>
                                           <input type="text" id="person_first_name" class="form-control" name="first_name" value="{{old('first_name')}}">

                                           @error('first_name')
                                           <span class="invalid-feedback d-block" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                           @enderror
                                       </div>



                                       <div class="form-group">
                                           <label for="person_last_name">Last name *</label>
                                           <input type="text" id="person_last_name" class="form-control" name="last_name"  value="{{old('last_name')}}">

                                           @error('last_name')
                                           <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                           @enderror
                                       </div>

                                       <div class="form-group">
                                           <label for="person_email">E-mail</label>
                                           <input type="email" id="person_email" class="form-control" name="email" value="{{old('email')}}">

                                           @error('email')
                                           <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                           @enderror
                                       </div>

                                       <div class="form-group">
                                           <label for="person_phone">Phone</label>
                                           <input type="number" id="person_phone" class="form-control"  name="phone"   value="{{old('phone')}}">

                                           @error('phone')
                                           <span class="invalid-feedback d-block" role="alert">
                                           <strong>{{ $message }}</strong>
                                        </span>
                                           @enderror
                                       </div>


                                       <div class="form-group">
                                           <label for="cv">Cv *</label>
                                           <input type="file" id="cv" class="form-control"  name="cv" style="padding-top: 3px!important;">

                                           @error('cv')
                                           <span class="invalid-feedback d-block" role="alert">
                                           <strong>{{ $message }}</strong>
                                        </span>
                                           @enderror
                                       </div>


                                       <div class="form-group">
                                           <button type="submit" class="btn btn-success float-right"><i class="fa fa-check-circle"></i> Submit
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
