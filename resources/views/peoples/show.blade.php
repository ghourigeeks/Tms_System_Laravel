@extends('layouts.main')
@section('title','People')
@section('content')
    @include( '../sweet_script')
    
    <div class="page-inner">
        <h4 class="page-title">@yield('title') Profile</h4>
        <div class="row row-card-no-pd">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-car text-success" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category">
                                        @if((isset($schedules))  && ($schedules > 0) )
                                            <a href="{{ url('peoples')}}/shdls/{{$data->id}}"> Schedules</a>
                                        @else
                                            Schedules
                                        @endif
                                    </p>
                                    <h4 class="card-title">{{ isset($schedules) ? ($schedules) : 0}} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-coins text-primary" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category">
                                        @if((isset($bookings))  && ($bookings > 0) )
                                            <a href="{{ url('peoples')}}/bkngs/{{$data->id}}"> Bookings</a>
                                        @else
                                            Bookings
                                        @endif
                                    </p>
                                    <h4 class="card-title"> {{ isset($bookings) ? ($bookings) : 0}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-envelope text-danger" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category">
                                        @if((isset($complaints))  && ($complaints > 0) )
                                            <a href="{{ url('peoples')}}/cmplnts/{{$data->id}}"> Complaints</a>
                                        @else
                                            Complaints
                                        @endif
                                    <h4 class="card-title"> {{ isset($complaints) ? ($complaints) : 0}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-star text-warning" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category"></p>
                                    <p class="card-category">
                                        @if((isset($ratings))  && ($ratings > 0) )
                                            <a href="{{ url('peoples')}}/rtngs/{{$data->id}}"> Captain Rating</a>
                                        @else
                                            Captain Rating
                                        @endif
                                    </p>
                                    <h4 class="card-title"> {{ isset($ratings) ? ($ratings) : 0}} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">@yield('title') </h4>
                            <span class="ml-auto">
                                @if((isset($data->active)) && ( ($data->active == 1) || ($data->active == "Active") ) )
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th width="40%">People</th>
                                            <td>{{$data->fname}}</td>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <td>{{ isset($detail->age) ? ($detail->age) . " years old"   :""}}</td>
                                        </tr>

                                        
                                        <tr>
                                            <th width="50%">CNIC</th>
                                            <td>{{ isset($data->cnic) ? ($data->cnic) :""}}</td>
                                        </tr>
                                        <tr>
                                            <th>Contact No</th>
                                            <td>{{ isset($data->contact_no) ? ($data->contact_no) :""}} </td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ isset($detail->address) ? ($detail->address) :""}}</td>
                                        </tr>
                                        <br>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card card-profile card-secondary">
                    <div class="card-header" style="background-image: url('../assets/img/blogpost.jpg')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                @if(isset($detail->profile_pic))
                                    <img src="{{ asset('/uploads/peoples/'.$detail->profile_pic) }}" alt="..." class="avatar-img rounded-circle"  style="width:80px; height:80px">
                                @else
                                    <img src="{{ asset('/uploads/no_image.png') }}" alt="..." class="avatar-img rounded-circle" style="width:80px; height:80px">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">
                                {{ucwords($data->fname)}} 
                                @if(isset($detail->verified) && $detail->verified == 0 )
                                    <i class="fas fa-times-circle" style="color:red;font-size:24px" data-toggle="tooltip" data-placement="top" title="Non-verified Profile"></i>
                                @else
                                    <i class="fas fa-check-circle" style="color:#4AD24E;font-size:24px" data-toggle="tooltip" data-placement="top" title="Verified Profile"></i>
                                @endif 
                            </div>
                            <div class="name"><b>{{($data->type)}}</b></div>
                            <div class="job">{{  isset($detail->email) ? ($detail->email) : "" }}</div>
                            <div class="job">{{(isset($detail->username) ? ($detail->username) : "")}}</div>
                          
                            
                            <!-- <div class="desc">A man who hates loneliness</div> -->
                            <div class="social-media">
                                <a class="btn btn-info btn-twitter btn-sm btn-link" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-twitter"></i> </span>
                                </a>
                                <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-google-plus"></i> </span> 
                                </a>
                                <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-facebook"></i> </span> 
                                </a>
                                <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-dribbble"></i> </span> 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                       
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">@yield('title') Vehicle(s)</h4>
                            <span class="ml-auto">
                                @if((isset($detail->license_no))  )
                                <b>Driver License# <span class="badge badge-success">{{($detail->license_no)}}</span></b>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Modal#</th>
                                            <th>Registration#</th>
                                            <th>Color</th>
                                            <th>Seats</th>
                                            <th>Tax Pic</th>
                                            <th>Status</th>
                                        </tr>

                                        @foreach($vehicles as $key => $vehicle)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>
                                                    @if(isset($vehicle->make))
                                                        {{$vehicle->make}}
                                                        @if(isset($vehicle->car_year))
                                                            - {{$vehicle->car_year}}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($vehicle->modal))
                                                        {{$vehicle->modal}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($vehicle->vehicle_registration))
                                                        {{$vehicle->vehicle_registration}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($vehicle->color))
                                                        {{$vehicle->color}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($vehicle->seat))
                                                        {{$vehicle->seat}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if((isset($vehicle->tax_pic)) && (file_exists( public_path('uploads/licenses/'.$vehicle->tax_pic) )))
                                                
                                                        <a href="#" class="pop">
                                                        <!-- id="imageresource" -->
                                                            <img  src="{{ asset('/uploads/licenses/'.$vehicle->tax_pic) }}" alt="..." class="avatar-img rounded-circle imageresource"  style="width:80px; height:80px">
                                                        
                                                        </a>
                                                    @else
                                                        <img src="{{ asset('/uploads/no_image.png') }}" alt="..." class="avatar-img rounded-circle" style="width:80px; height:80px">
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="ml-auto">
                                                        @if((isset($vehicle->active)) && ( ($vehicle->active == 1) ) )
                                                            <i class="fas fa-check-circle" style="color:#4AD24E;font-size:24px" data-toggle="tooltip" data-placement="top" title="Active"></i>
                                                        @else
                                                            <i class="fas fa-times-circle" style="color:red;font-size:24px" data-toggle="tooltip" data-placement="top" title="Inactive"></i>
                                                        @endif 
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <br>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Creates the bootstrap modal where the image will appear -->
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <h4 class="modal-title" id="myModalLabel">Image preview</h4> -->
                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview" style="width: 468px; height: 264px;" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(".pop").on("click", function() {
            $('#imagepreview').attr('src',$(this).find(".imageresource").attr('src'));
            $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });


    </script>
  
@endsection
