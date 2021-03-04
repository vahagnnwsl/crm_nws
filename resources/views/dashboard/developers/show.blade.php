@extends('dashboard.layouts')
@push('css')
    <style>
        td {
            font-size: 1.2rem;
        }
    </style>
@endpush
@section('sub_content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Developer <span class="text-blue">{{$developer->fullName}}</span></h1>
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
                       <div class="col-md-6 mx-auto">
                           <table>
                               <tr>
                                   <td width="20%"><strong class="text-primary">Full name: </strong></td>
                                   <td width="10%"></td>
                                   <td width="70%"> {{$developer->fullName}}</td>
                               </tr>
                               <tr>
                                   <td><strong class="text-primary">Position: </strong></td>
                                   <td width="10%"></td>
                                   <td> {{$developer->position}}</td>
                               </tr>
                               <tr>
                                   <td><strong class="text-primary">Status: </strong></td>
                                   <td width="10%"></td>
                                   <td> {{$developerStatuses[$developer->status]}}</td>
                               </tr>
                               <tr>
                                   <td><strong class="text-primary">Email: </strong></td>
                                   <td width="10%"></td>
                                   <td> {{$developer->email}}</td>
                               </tr>
                               <tr>
                                   <td><strong class="text-primary">Phone: </strong></td>
                                   <td width="10%"></td>
                                   <td> {{$developer->phone}}</td>
                               </tr>
                               <tr>
                                   <td><strong class="text-primary">Date: </strong></td>
                                   <td width="10%"></td>
                                   <td> {{$developer->created_at->format('d.m.Y')}}</td>
                               </tr>
                               <tr>
                                   <td><strong class="text-primary">Cv: </strong></td>
                                   <td width="10%"></td>
                                   <td>
                                       @if($developer->cv)
                                           <a href="{{$developer->cv}}" target="_blank">{{$developer->cv}}</a>
                                       @endif
                                   </td>
                               </tr>
                           </table>
                       </div>
                </div>
            </div>
        </div>
    </section>
@endsection
