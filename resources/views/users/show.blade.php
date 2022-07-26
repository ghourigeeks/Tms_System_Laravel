@extends('layouts.main')
@section('title','User')
@section('content')
@include( '../sweet_script')
    <div class="page-inner">
        <h4 class="page-title">@yield('title') Profile</h4>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">@yield('title')</h4>
                            <a  href="{{ route('users.index') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th width="50%">Full name</th>
                                            <td>{{$data->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{$data->email}}</td>
                                        </tr>
                                        <tr>
                                            <th>description</th>
                                            <td>{{$data->description}}</td>
                                        </tr>
                                       
                                        <tr>
                                            <th>Contact No</th>
                                            <td>{{$data->contact_no}}</td>
                                        </tr>
                                        <tr>
                                            <th>Role</th>
                                            <td>{{$data->rn}}</td>
                                        </tr>
                                       
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if((isset($data->active)) && ( ($data->active == 1) || ($data->active == "Active") ) )
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <br>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-profile card-secondary">
                    <div class="card-header" style="background-image: url('../assets/img/blogpost.jpg')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                @if($data->profile_pic)
                                    <img src="{{ asset('/uploads/users/'.$data->profile_pic) }}" alt="..." class="avatar-img rounded-circle">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">{{ucwords($data->name)}}</div>
                            <div class="job">{{($data->email)}}</div>
                            <div class="job">{{($data->rn)}}</div>
                            <!-- <div class="desc">A man who hates loneliness</div> -->
                          
                            <div class="view-profile">
                                <a href="#" class="btn btn-primary btn-block">View Image</a>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
  

@endsection
